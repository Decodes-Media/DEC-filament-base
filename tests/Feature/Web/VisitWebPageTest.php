<?php

use function Pest\Laravel\get;

uses(\Tests\TestCase::class);

test('hi index', function () {
    //
    get(route('index'))
        ->assertOk()
        ->assertSee(__('admin.welcome'));
});
