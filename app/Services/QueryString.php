<?php

namespace App\Services;


use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class QueryString
{
    public static array|null $relationships = null;
    public static string|null $paginate = null;
    public static array|null $sorting = null;
    public static string|null $model = null;
    public static Collection|null $fields = null;
    public static Collection|LengthAwarePaginator|null $instances = null;

    public static EloquentBuilder|Builder|null $builder = null;

    public static function handle(Collection $queryString, string $model, string $table): mixed
    {
        self::$relationships = config("relationships.$table");
        self::$model = $model;
        self::parseQueryString($queryString);
        self::handleField();
        self::handleSorting();
        self::getInstances();

        return self::$instances;
    }

    private static function handleSorting(): void
    {
        if(!is_null(self::$sorting)) {
            $field = self::$sorting['field'];
            $type = self::$sorting['type'];
            if(!is_null(self::$builder)) self::$builder = self::$builder->orderBy($field, $type);
            else self::$builder = self::$model::orderBy($field, $type);
        }
    }

    private static function getInstances(): void
    {
        $instances = null;
        if(isset(self::$paginate)) {
            if(isset(self::$builder)) $instances = self::$builder->paginate(self::$paginate);
            else $instances = self::$model::paginate(self::$paginate);
        } else {
            if(isset(self::$builder)) $instances = self::$builder->get();
            else $instances = self::$model::get();
        }

        self::$instances = $instances;
    }

    private static function handleField(): void
    {
        if(!is_null(self::$fields)) {
            foreach (self::$fields as $fieldName => $paramsString) {
                $fieldParams = explode('|', $paramsString);

                if(isset($fieldParams[2])) {
                    /* Указаны table, value, like */
                    $paramsTable = $fieldParams[0];
                    $bindingMethod = self::$relationships[$paramsTable];
                    $paramsValue = $fieldParams[1];
                    $paramsLike = $fieldParams[2];

                    self::$builder = self::$model::whereHas($bindingMethod, function ($query)
                    use($paramsValue, $paramsLike, $fieldName)
                    {
                        $query->where($fieldName, $paramsLike, "%$paramsValue%");
                    });
                } else if(isset($fieldParams[1]) AND $fieldParams[1] !== 'like') {
                    /* Указаны table, value */
                    $paramsTable = $fieldParams[0];
                    $bindingMethod = self::$relationships[$paramsTable];
                    $paramsValue = $fieldParams[1];

                    self::$builder = self::$model::whereHas($bindingMethod, function ($query)
                    use($paramsValue, $fieldName)
                    {
                        $query->where($fieldName, $paramsValue);
                    });
                } else if(isset($fieldParams[0])) {
                    /* Указано только value */
                    $paramsValue = $fieldParams[0];
                    $paramsLike = isset($fieldParams[1])? $fieldParams[1]: null;

                    if(is_null($paramsLike)) self::$builder = self::$model::where($fieldName, $paramsValue);
                    else self::$builder = self::$model::where($fieldName, $paramsLike, "%$paramsValue%");
                }
            }
        }
    }

    private static function parseQueryString(Collection $queryString): void
    {
        self::$paginate = $queryString->pull('paginate');
        $sortingParamsString = $queryString->pull('sort');
        if(isset($sortingParamsString)) {
            $temp_arr = [];
            $sortingParamsArray = explode('|', $sortingParamsString);
            if(isset($sortingParamsArray[0])) {
                $temp_arr['field'] = $sortingParamsArray[0];
                $temp_arr['type'] = isset($sortingParamsArray[1])? $sortingParamsArray[1]: 'asc';
            }
            self::$sorting = $temp_arr;
        }

        if($queryString->isNotEmpty()) self::$fields = $queryString;
        else self::$fields = null;
    }
}
