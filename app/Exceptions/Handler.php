<?php

namespace App\Exceptions;

use App\Traits\HasResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof ValidationException) {
            return response()->json(
                [
                    'data' => [],
                    'message' => $e->getMessage(),
                    'success' => false,
                    'status' => 422
                ]
                , 422);
        }
        if (app()->environment('local') || app()->environment('development')) {
            return parent::render($request, $e);

        } elseif (app()->environment('production')) {

            return $this->handleExceptions($e);
        }
        return response()->json(
            [
                'data' => [],
                'message' => 'Please Set Your App Environment`.',
                'success' => false,
                'status' => 400
            ]
        );
    }

    protected function handleExceptions(Throwable $e): JsonResponse
    {
        if ($e instanceof AuthenticationException) {
            return response()->json(
                [
                    'data' => [],
                    'message' => 'Unauthenticated',
                    'success' => false,
                    'status' => 401
                ]
                , 401);
        } elseif ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            // Model not found exception
            $model = explode('\\', $e->getModel())[2];
            return response()->json(
                [
                    'data' => [],
                    'message' => false,
                    'success' => $model . ' Not Found.',
                    'status' => 404
                ]
                , 404);
        } elseif ($e instanceof \Illuminate\Validation\ValidationException) {
            // Validation exception
            return response()->json(
                [
                    'data' => [],
                    'message' => false,
                    'success' => 'Errors:' . $e->validator->errors(),
                    'status' => 422
                ]
                , 422);
        } elseif ($e instanceof AccessDeniedHttpException) {
            // AccessDenied exception
            return response()->json(
                [
                    'data' => [],
                    'message' => false,
                    'success' => 'Access Denied.',
                    'status' => 403
                ]
                , 403);
        } elseif ($e instanceof NotFoundHttpException) {
            // Page not found Exception
            return response()->json(
                [
                    'data' => [],
                    'message' => false,
                    'success' => 'Url Not Found.',
                    'status' => 404
                ]
                , 404);
        } else {
            //server errors
            return response()->json(
                [
                    'data' => [],
                    'message' => false,
                    'success' => 'Server Error',
                    'status' => 500
                ]
                , 500);
        }
    }
}
