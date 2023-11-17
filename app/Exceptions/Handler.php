<?php

namespace App\Exceptions;

use App\Services\Helper;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (Throwable $e, Request $request) {
            if($request->expectsJson()) {
                if($e instanceof ValidationException) {
                    $error = [
                        'message' => 'Validation errors',
                        'fields' => array_combine(array_keys($e->errors()) ,Arr::collapse($e->errors()))
                    ];
                    return new JsonResponse(['error' => $error], Response::HTTP_UNPROCESSABLE_ENTITY);
                } else if($e instanceof AuthenticationException) {
                    $error = ['message' => $e->getMessage()];
                    return new JsonResponse(['error' => $error], Response::HTTP_UNAUTHORIZED);
                } else if($e instanceof NotFoundHttpException) {
                    $error = ['message' => 'Invalid URI'];
                    return new JsonResponse(['error' => $error], Response::HTTP_NOT_FOUND);
                } else if($e instanceof AccessDeniedHttpException) {
                    $error = ['message' => $e->getMessage()];
                    return new JsonResponse(['error' => $error], Response::HTTP_UNAUTHORIZED);
                }
//                } else if($e instanceof QueryException) {
//                    $error = ['message' => 'Invalid query string'];
//                    return new JsonResponse(['error' => $error], Response::HTTP_BAD_REQUEST);
//                }
            }
        });
    }
}
