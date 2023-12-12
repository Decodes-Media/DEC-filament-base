<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use KodePandai\ApiResponse\ApiResponse;

class MiscApiController extends Controller
{
    public function index(): ApiResponse
    {
        return ApiResponse::success()
            ->title('API')
            ->message(__('admin.welcome'));
    }

    public function ping(): ApiResponse
    {
        return ApiResponse::success()
            ->title('API')
            ->message('Ping')
            ->data([
                'ping' => 'pong',
                'app_version' => config('app.version'),
                'process_time' => round(microtime(true) - LARAVEL_START, 8),
            ]);
    }
}
