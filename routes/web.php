<?php

use App\Http\Controllers\Web\MiscWebController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Base
|--------------------------------------------------------------------------
*/

Route::get('/', [MiscWebController::class, 'index'])
    ->name('index');

Route::view('/empty', 'empty')
    ->name('empty');

Route::view('/test-b4-tw', 'client.test-b4-tw')
    ->name('test-b4-tw');

Route::view('/lorem', 'client.lorem')
    ->name('lorem');

Route::redirect('/login', '/')
    ->name('login');

/*
|--------------------------------------------------------------------------
| Web Extra
|--------------------------------------------------------------------------
*/
