<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use KodePandai\ApiResponse\ApiExceptionHandler;
use KodePandai\ApiResponse\Exceptions\ApiException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $levels = [
        // pass
    ];

    protected $dontReport = [
        \KodePandai\ApiResponse\Exceptions\ApiException::class,
        \KodePandai\ApiResponse\Exceptions\ApiValidationException::class,
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // pass
        });

        $this->renderable(function (Throwable $e, Request $request) {
            //
            if (is_request_for_api($request)) {
                //
                if ($e instanceof ThrottleRequestsException) {
                    return ApiException::error()
                        ->statusCode($e->getStatusCode())
                        ->title(__('api.rate_limiter'))
                        ->message(__('api.too_many_request_please_try_again_later'));
                }

                return ApiExceptionHandler::render($e, $request);
            }
        });
    }
}
