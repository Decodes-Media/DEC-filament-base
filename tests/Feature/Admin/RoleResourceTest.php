<?php

use App\FilamentAdmin\Resources\RoleResource;
use App\FilamentAdmin\Resources\RoleResource\Pages\CreateRole;
use App\FilamentAdmin\Resources\RoleResource\Pages\EditRole;
use App\FilamentAdmin\Resources\RoleResource\Pages\ListRoles;
use App\FilamentAdmin\Resources\RoleResource\Pages\ViewRole;
use App\Models\Admin;
use App\Models\Role;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Config;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertModelExists;
use function Pest\Laravel\assertModelMissing;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses(\Tests\TestCase::class);

beforeEach(fn () => actingAs(Admin::first(), 'admin'));

// TODO: test attached users
// TODO: test attached permissions

test('visit list page', function () {
    //
    get(RoleResource::getUrl('index'))
        ->assertOk()
        ->assertSee(__('Roles'));

    livewire(ListRoles::class)
        ->assertCanSeeTableRecords(Role::take(5)->get());
});

test('visit create form', function () {
    //
    get(RoleResource::getUrl('create'))
        ->assertOk()
        ->assertSee(__('Role'));
});

test('validate create form', function () {
    //
    livewire(CreateRole::class)
        ->fillForm([])
        ->call('create')
        ->assertHasFormErrors([
            'name' => 'required',
        ]);
});

test('submit create form', function () {
    //
    livewire(CreateRole::class)
        ->fillForm([
            'name' => 'Test role',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $role = Role::latest()->first();

    expect($role)
        ->name->toBe('Test role');
});

test('cant create exceed limit', function () {
    //
    Config::set('base.records_limit.roles', 1);

    $msg = __('Cannot create new record, limit excedeed');
    $notif = Notification::make()->danger()->title($msg);

    livewire(CreateRole::class)
        ->assertRedirect();

    Notification::assertNotified($notif);
});

test('visit detail page', function () {
    //
    $role = Role::inRandomOrder()->first();

    get(RoleResource::getUrl('view', ['record' => $role]))
        ->assertOk()
        ->assertSee(__('Role'))
        ->assertSee($role->name);
});

test('visit edit form', function () {
    //
    $role = Role::inRandomOrder()->first();

    get(RoleResource::getUrl('edit', ['record' => $role]))
        ->assertOk()
        ->assertSee(__('Roles'));

    livewire(EditRole::class, ['record' => $role->id])
        ->assertFormSet([
            'name' => $role->name,
        ]);
});

test('submit edit form', function () {
    //
    $role = Role::create(['name' => 'test', 'guard_name' => 'admin']);

    get(RoleResource::getUrl('edit', ['record' => $role]))
        ->assertOk()
        ->assertSee(__('Roles'));

    livewire(EditRole::class, ['record' => $role->id])
        ->fillForm([
            'name' => 'new name',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $role->refresh();

    expect($role)
        ->name->toBe('new name')
        ->guard_name->toBe('admin');
});

test('cant edit superadmin role', function () {
    //
    $role = Role::firstWhere('name', 'Superadmin');

    $msg = __('Failed, cannot edit Superadmin role');
    $notif = Notification::make()->danger()->title($msg);

    livewire(EditRole::class, ['record' => $role->id])
        ->fillForm([
            'name' => 'new name',
        ])
        ->call('save')
        ->assertNotified($notif);

    $role->refresh();

    expect($role)
        ->name->toBe('Superadmin')
        ->guard_name->toBe('admin');
});

test('submit delete action', function () {
    //
    $role = Role::create(['name' => 'test', 'guard_name' => 'admin']);

    livewire(ViewRole::class, ['record' => $role->id])
        ->callAction(DeleteAction::class);

    assertModelMissing($role);
});

test('cant delete superadmin role', function () {
    //
    $role = Role::firstWhere('name', 'Superadmin');

    $msg = __('Failed, cannot delete Superadmin role');
    $notif = Notification::make()->danger()->title($msg);

    livewire(ViewRole::class, ['record' => $role->id])
        ->callAction(DeleteAction::class)
        ->assertNotified($notif);

    assertModelExists($role);
});

test('cant delete attached role', function () {
    //
    $role = Role::create(['name' => 'test', 'guard_name' => 'admin']);

    Admin::inRandomOrder()->first()->assignRole($role);

    $msg = __('Failed, cannot delete role that has been attached to admins');
    $notif = Notification::make()->danger()->title($msg);

    livewire(ViewRole::class, ['record' => $role->id])
        ->callAction(DeleteAction::class)
        ->assertNotified($notif);

    assertModelExists($role);
});
