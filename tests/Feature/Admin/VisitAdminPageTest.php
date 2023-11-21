<?php

use App\Models\Admin;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(\Tests\TestCase::class);

beforeEach(fn () => actingAs(Admin::first(), 'web:admin'));

test('visit dashboard', function () {
    //
    get(route('filament.admin.pages.dashboard-page'))->assertOk();
});
