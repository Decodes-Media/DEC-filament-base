<?php

use App\Models\Main\Admin;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(\Tests\TestCase::class);

beforeEach(fn () => actingAs(Admin::first(), 'admin'));

test('visit dashboard', function () {
    //
    get(route('filament.admin.pages.dashboard-page'))
        ->assertOk();
});
