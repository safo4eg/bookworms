<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
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
                    return new JsonResponse([
                        'error' => [
                            'message' => 'Validation errors',
                            'status' => $e->status,
                            'fields' => array_combine(array_keys($e->errors()) ,Arr::collapse($e->errors()))
                        ]
                    ]);
                }
            }
        });
    }
}
