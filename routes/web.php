<?php

use App\Http\Controllers\Web\MiscWebController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MiscWebController::class, 'index'])
    ->name('index');

Route::get('/empty', [MiscWebController::class, 'empty'])
    ->name('empty');

Route::redirect('/login', '/')->name('login');
