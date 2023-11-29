<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class QueryStringService
{
    private static array $clarification;
    private static Request $request;
    private static string $model;

    private static string|null $sort;
    private static string|null $paginate;
    private static string|null $limit;
    private static Collection $filter;

    private static Builder $builder;

    public static function handle(Request $request, string $model): Collection|LengthAwarePaginator
    {
        self::$clarification = config('clarification');
        self::$request = $request;
        self::$model = $model;

        self::parseQueryString();
        switch (self::$model) {
            case Book::class:
                self::handleBookQuery();
                self::$clarification = config('clarification')['books'];
                break;
        }
        self::sort();
        self::limit();
        self::getInstances();

        return self::getInstances();
    }

    private static function getInstances(): Collection|LengthAwarePaginator
    {
        $paginate = trim(self::$paginate);
        if(!empty($paginate)) {
            if(!is_numeric($paginate)) {
                $exceptionMessage = "Value must be a number";
                self::throwQueryException('limit', $exceptionMessage);
            }
            if(!isset(self::$builder)) self::$builder = self::$model::query();
            return self::$builder->paginate($paginate);
        } else {
            if(isset(self::$builder)) return self::$builder->get();
            else return self::$model::all();
        }
    }

    private static function limit()
    {
        $limit = trim(self::$limit);
        if(!empty($limit)) {
            if(!is_numeric($limit)) {
                $exceptionMessage = "Value must be a number";
                self::throwQueryException('limit', $exceptionMessage);
            }
            if(!isset(self::$builder)) self::$builder = self::$model::query();
            self::$builder->offset(0)->limit($limit);
        }
    }

    private static function sort()
    {
        $field = trim(self::$sort);
        if(!empty($field)) {
            $permittedFields = self::$clarification['sort']['fields'];
            if(!in_array($field, $permittedFields)) {
                $exceptionMessage = "Field not supported";
                self::throwQueryException($field, $exceptionMessage);
            }

            if(!isset(self::$builder)) self::$builder = self::$model::query();
            $type = 'asc';
            $field = trim(self::$sort);
            if(preg_match('#^-.+$#', $field)) {
                $type = 'desc';
                $field = preg_replace('#^-#', '', $field);
            }
            self::$builder->orderBy($field, $type);
        }
    }

    private static function handleBookQuery(): void
    {
        if(self::$filter->isNotEmpty()) {
            $permittedRelationships = self::$clarification['books']['relationships'];
            $permittedFields = self::$clarification['books']['fields'];

            foreach (self::$filter as $outerKey => $outerValue) {
                if(is_array($outerValue)) {
                    if(array_key_exists($outerKey, $permittedRelationships)) {
                        $relationshipMethodName = $permittedRelationships[$outerKey]['relationship'];
                        $relationshipParamsArray = self::parseRelationshipParamsArray(
                            $relationshipMethodName,
                            $outerValue
                        );

                        foreach ($relationshipParamsArray[$relationshipMethodName] as $innerKey => $innerValue) {
                            if(!array_key_exists($innerKey, $permittedRelationships[$outerKey]['fields'])) {
                                $exceptionMessage = "Field not supported";
                                self::throwQueryException($outerKey, $exceptionMessage);
                            } else if(
                                isset($innerValue['option'])
                                AND !in_array($innerValue['option'], $permittedRelationships[$outerKey]['fields'][$innerKey])
                            ) {
                                $exceptionMessage = "Option not supported";
                                self::throwQueryException($outerKey, $exceptionMessage);
                            } else {
                                if($relationshipMethodName === 'user') {
                                    $userId = self::$request->user()->id;
                                    if($innerKey === 'rating') {
                                        $sign = $innerValue['sign'];
                                        $number = null;
                                        if($sign !== '*') $number = $innerValue['number'];
                                        self::$builder = Book::whereHas(
                                            'ratings',
                                            function ($query) use($sign, $number, $userId) {
                                                if($sign === '*') {
                                                    $query->where('user_id', $userId);
                                                } else {
                                                    $query->where('user_id', $userId)->where('rating', $sign, $number);
                                                }
                                            }
                                        );
                                    } else if($innerKey === 'review') {
                                        self::$builder = Book::whereHas(
                                            'reviews',
                                            function ($query) use ($userId) {
                                                $query->where('user_id', $userId);
                                            }
                                        );
                                    }
                                } else {
                                    self::$builder = Book::whereHas(
                                        $relationshipMethodName,
                                        function ($query) use($innerKey, $innerValue) {
                                            if(!is_null($innerValue['option'])) {
                                                switch ($innerValue['option']) {
                                                    case 'like':
                                                        $query->where($innerKey, 'like', "%{$innerValue['value']}%");
                                                        break;
                                                }
                                            } else {
                                                $query->where($innerKey, $innerValue['value']);
                                            }
                                        }
                                    );
                                }
                            }
                        }

                    } else {
                        $exceptionMessage = "Not included in available relationships";
                        self::throwQueryException($outerKey, $exceptionMessage);
                    }
                } else {
                    if(!array_key_exists($outerKey, $permittedFields)) {
                        $exceptionMessage = "Field not supported";
                        self::throwQueryException($outerKey, $exceptionMessage);
                    } else {
                        $paramsArray = self::parseFieldParams($outerValue, $outerKey);
                        if($outerKey === 'rating') {
                            if($paramsArray['option'] === 'avg') {
                                $sign = $paramsArray['sign'];
                                $number = $paramsArray['number'];
                                self::$builder = Book::whereHas(
                                    'ratings',
                                    function ($query) use ($sign, $number) {
                                        $query->groupBy('rating')->havingRaw("AVG(rating) $sign $number");
                                    }
                            );
                            }
                        } else {
                            if(!is_null($paramsArray['option'])) {
                                if($paramsArray['option'] === 'like') {
                                    self::$builder = Book::where($outerKey, 'like', "%{$paramsArray['value']}%");
                                }
                            } else {
                                self::$builder = Book::where($outerKey, $paramsArray['value']);
                            }
                        }
                    }
                }
            }
        }
    }

    private static function parseFieldParams(string $fieldParams, string $fieldName): array
    {
        $array = [];
        $explodedString = explode(":", $fieldParams);
        if(empty($explodedString[0])) {
            $exceptionMessage = "Field query params cannot be empty";
            self::throwQueryException($fieldName, $exceptionMessage);
        } else {
            if($explodedString[0] === 'avg' AND $fieldName === 'rating') {
                $regExp = '#^(?<sign>(>=)|(<=)|<|>|=){1}(?<number>.+)$#';
                if(!preg_match($regExp, $explodedString[1], $matches)) {
                    $exceptionMessage = "Invalid option";
                    self::throwQueryException($fieldName, $exceptionMessage);
                } else {
                    $array['sign'] = $matches['sign'];
                    $array['number'] = $matches['number'];
                    $array['option'] = $explodedString[0];
                }
            } else {
                $array['value'] = $explodedString[0];
                if(!empty($explodedString[1])) $array['option'] = $explodedString[1];
                else $array['option'] = null;
            }
        }

        return $array;
    }

    private static function parseRelationshipParamsArray(string $relationship, array $paramsArray): array
    {
        $array = [$relationship => []];

        if($relationship === 'user') {
            foreach ($paramsArray as $key => $value) {
                if($key === 'rating') {
                    if($value === '*') $array[$relationship][$key]['sign'] = "*";
                    else {
                        $regExp = '#^(?<sign>(>=)|(<=)|<|>|=){1}(?<number>.+)$#';
                        if(!preg_match($regExp, $value, $matches)) {
                            $exceptionMessage = "Invalid option";
                            self::throwQueryException($key, $exceptionMessage);
                        } else {
                            $array[$relationship][$key]['sign'] = $matches['sign'];
                            $array[$relationship][$key]['number'] = $matches['number'];
                        }
                    }
                } else if($key === 'review') {
                    if($value === '*') $array[$relationship][$key]['sign'] = "*";
                    else {
                        $exceptionMessage = "Invalid option";
                        self::throwQueryException($key, $exceptionMessage);
                    }
                }
            }
        } else {
            foreach($paramsArray as $key => $value) {
                $parsedKey = explode(':', $key);
                if(isset($parsedKey[0]) AND !empty($parsedKey[0])) {
                    if(isset($parsedKey[1]) AND !empty($parsedKey[1])) {
                        $array[$relationship][$parsedKey[0]]['option'] = $parsedKey[1];
                    } else {
                        $array[$relationship][$parsedKey[0]]['option'] = null;
                    }
                    $array[$relationship][$parsedKey[0]]['value'] = $value;
                } else {
                    $exceptionMessage = "The query string is incorrectly formulated";
                    self::throwQueryException($relationship, $exceptionMessage);
                }
            }
        }

        return $array;
    }

    private static function parseQueryString(): void
    {
        $collectionQueryParams = self::$request->collect();
        self::$sort = $collectionQueryParams->pull('sort');
        self::$limit = $collectionQueryParams->pull('limit');
        self::$paginate = $collectionQueryParams->pull('paginate');
        self::$filter = $collectionQueryParams;
    }

    private static function throwQueryException(string $field, string $message)
    {
        throw ValidationException::withMessages([
            $field => $message
        ]);
    }
}
