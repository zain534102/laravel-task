<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
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
        $this->renderable(function (ValidationException $exception, $request) {
            if($request->expectsJson()){
                return response()->json([
                    'success' => false,
                    'message' => "Validator Error",
                    'errors'  => $exception->errors()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        });
        $this->renderable(function (NotFoundHttpException $exception, $request) {
            if($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "Route not found",
                    'errors' => []
                ], Response::HTTP_NOT_FOUND);
            }
        });
        $this->renderable(function (MethodNotAllowedHttpException $exception, $request) {
            if($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "Method not allowed",
                    'errors' => []
                ], Response::HTTP_METHOD_NOT_ALLOWED);
            }
        });
    }
}
