<?php

use function Pest\Laravel\getJson;

uses(\Tests\TestCase::class);

test('hi index', function () {
    //
    getJson(route('api.index'))
        ->assertOk()
        ->assertJsonPath('message', __('admin.welcome'))
        ->assertJsonPath('data', []);
});

test('ping pong', function () {
    //
    if (! defined('LARAVEL_START')) {
        define('LARAVEL_START', microtime(true));
    }

    getJson(route('api.ping'))
        ->assertOk()
        ->assertJsonPath('message', 'Ping')
        ->assertJsonPath('data.ping', 'pong')
        ->assertJsonPath('data.app_version', 'v0.0.1');
});
