<?php

use App\Helpers\ApiResponse;
use App\Http\Middleware\ApiJsonResponseMiddleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log as FacadesLog;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        // web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        // commands: __DIR__ . '/../routes/console.php',
        // health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(ApiJsonResponseMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e, Request $request) {
            FacadesLog::info('EXCEPTION CAUGHT: ' . get_class($e));
            if ($request->expectsJson()) {
                if ($e instanceof ValidationException) {
                    return ApiResponse::error('Validation Error', $e->errors(), 422);
                }

                if ($e instanceof NotFoundHttpException) {
                    return ApiResponse::error('Not Found', $e->getMessage(), 404);
                }

                if ($e instanceof MethodNotAllowedHttpException) {
                    return ApiResponse::error('Method Not Allowed', $e->getMessage(), 405);
                }

                if ($e instanceof AuthenticationException) {
                    return ApiResponse::error('Unauthorized', $e->getMessage(), 401);
                }

                $status = $e instanceof HttpExceptionInterface ? $e->getStatusCode() : 500;
                return ApiResponse::error('Internal Server Error', $e->getMessage(), $status);
            }
            return ApiResponse::error('Internal Server Error', $e->getMessage(), 500);
        });
    })
    ->create();
