<?php

use App\Http\Controllers\Api\MiscApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Api Base
|--------------------------------------------------------------------------
*/

Route::get('/', [MiscApiController::class, 'index'])
    ->name('api.index');

Route::get('/ping', [MiscApiController::class, 'ping'])
    ->name('api.ping');

/*
|--------------------------------------------------------------------------
| Api Extra
|--------------------------------------------------------------------------
*/
