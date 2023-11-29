<?php

use App\FilamentAdmin\Resources\AdminResource;
use App\FilamentAdmin\Resources\AdminResource\Pages\CreateAdmin;
use App\FilamentAdmin\Resources\AdminResource\Pages\EditAdmin;
use App\FilamentAdmin\Resources\AdminResource\Pages\ListAdmins;
use App\FilamentAdmin\Resources\AdminResource\Pages\ViewAdmin;
use App\Models\Admin;
use App\Models\Role;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertModelExists;
use function Pest\Laravel\assertModelMissing;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

uses(\Tests\TestCase::class);

beforeEach(fn () => actingAs(Admin::first(), 'admin'));

test('visit list page', function () {
    //
    get(AdminResource::getUrl('index'))
        ->assertOk()
        ->assertSee(__('Admins'));

    livewire(ListAdmins::class)
        ->assertCanSeeTableRecords(Admin::take(5)->get());
});

test('visit create form', function () {
    //
    get(AdminResource::getUrl('create'))
        ->assertOk()
        ->assertSee(__('Admin'));
});

test('validate create form', function () {
    //
    livewire(CreateAdmin::class)
        ->fillForm([])
        ->call('create')
        ->assertHasFormErrors([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required',
        ]);
});

test('submit create form', function () {
    //
    $role = Role::inRandomOrder()->first();

    livewire(CreateAdmin::class)
        ->fillForm([
            'name' => 'Test name',
            'email' => 'test@mail.com',
            'password' => 'lalalayeyeye',
            'password_confirmation' => 'lalalayeyeye',
            'is_active' => true,
            'roles' => [$role->id],
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $admin = Admin::latest()->first();

    expect($admin)
        ->name->toBe('Test name')
        ->email->toBe('test@mail.com')
        ->password->not->toBeEmpty()
        ->password_updated_at->not->toBeEmpty()
        ->is_active->toBeTrue();

    expect($admin->roles)
        ->first()->not->toBeEmpty()
        ->first()->id->toBe($role->id);
});

test('cant create exceed limit', function () {
    //
    Config::set('base.records_limit.admins', 1);

    $msg = __('Cannot create new record, limit excedeed');
    $notif = Notification::make()->danger()->title($msg);

    livewire(CreateAdmin::class)
        ->assertRedirect();

    Notification::assertNotified($notif);
});

test('visit detail page', function () {
    //
    $admin = Admin::inRandomOrder()->first();

    get(AdminResource::getUrl('view', ['record' => $admin]))
        ->assertOk()
        ->assertSee(__('Admin'))
        ->assertSee($admin->name);
});

test('visit edit form', function () {
    //
    $admin = Admin::inRandomOrder()->first();

    get(AdminResource::getUrl('edit', ['record' => $admin]))
        ->assertOk()
        ->assertSee(__('Admin'));

    livewire(EditAdmin::class, ['record' => $admin->id])
        ->assertFormSet([
            'name' => $admin->name,
            'email' => $admin->email,
            'is_active' => $admin->is_active,
            // 'roles' => $admin->roles->toArray(), // TODO: fix me
        ]);
});

test('submit edit form', function () {
    //
    $admin = Admin::factory()->create();

    get(AdminResource::getUrl('edit', ['record' => $admin]))
        ->assertOk()
        ->assertSee(__('Admin'))
        ->assertSee($admin->name);

    livewire(EditAdmin::class, ['record' => $admin->id])
        ->fillForm([
            'name' => 'new name',
            // 'email' => 'new@email.com',
            'is_active' => false,
            // 'roles' => $admin->roles->toArray(), // TODO: fix me
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $admin->refresh();

    expect($admin)
        ->name->toBe('new name')
        // ->email->toBe('new@meial.com')
        ->is_active->toBeFalse();
});

test('submit delete action', function () {
    //
    $admin = Admin::factory()->create(['is_active' => false]);

    livewire(ViewAdmin::class, ['record' => $admin->id])
        ->callAction(DeleteAction::class);

    assertModelMissing($admin);
});

test('cant delete your self', function () {
    //
    $admin = Admin::factory()->create();
    actingAs($admin);

    $msg = __('Failed, cannot delete your self');
    $notif = Notification::make()->danger()->title($msg);

    livewire(ViewAdmin::class, ['record' => $admin->id])
        ->callAction(DeleteAction::class)
        ->assertNotified($notif);

    assertModelExists($admin);
});

test('cant delete superadmin user', function () {
    //
    $admin = Admin::factory()->create();
    $super = Admin::firstWhere('email', config('base.superadmin_email'));

    actingAs($admin);

    $msg = __('Failed, cannot delete Superadmin user');
    $notif = Notification::make()->danger()->title($msg);

    livewire(ViewAdmin::class, ['record' => $super->id])
        ->callAction(DeleteAction::class)
        ->assertNotified($notif);

    assertModelExists($super);
});

test('cant delete active user', function () {
    //
    $admin = Admin::factory()->create();

    $msg = __('Failed, cannot delete active admin');
    $notif = Notification::make()->danger()->title($msg);

    livewire(ViewAdmin::class, ['record' => $admin->id])
        ->callAction(DeleteAction::class)
        ->assertNotified($notif);

    assertModelExists($admin);
});

test('submit reset password action', function () {
    //
    $admin = Admin::factory()->create();
    $admin->password = Hash::make('hehehehe');
    $admin->save();

    livewire(ViewAdmin::class, ['record' => $admin->id])
        ->mountAction('reset-password')
        ->setActionData([
            'new_password' => 'hahahaha',
            'new_password_confirmation' => 'hahahaha',
        ])
        ->callMountedAction()
        ->assertHasNoActionErrors();

    $admin->refresh();

    assertFalse(Hash::check('hehehehe', $admin->password));
    assertTrue(Hash::check('hahahaha', $admin->password));

    expect($admin->password_updated_at)->not->toBeEmpty();
});
