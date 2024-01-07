<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AdminResource\Pages;
use App\Models\Main\Admin;
use App\Support\FilamentBase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;

    protected static ?string $slug = 'admins';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('admin.access');
    }

    public static function getModelLabel(): string
    {
        return __('admin.admin');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.admins');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            FilamentBase\Forms\CreatorEditorPlaceholder::make(),
            Forms\Components\Section::make(__('admin.about'))
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label(__('admin.name'))
                        ->disabled(fn ($record, $context) => //
                            $context != 'create' && (
                                $record?->id == user_id('admin')
                                || $record?->email == config('base.superadmin_email')
                            ),
                        )
                        ->required(),
                    Forms\Components\TextInput::make('email')
                        ->label(__('admin.email'))
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->disabledOn('edit'),
                    Forms\Components\TextInput::make('password')
                        ->label(__('admin.password'))
                        ->password()
                        ->required()
                        ->confirmed()
                        ->rule(Password::default())
                        ->visibleOn('create')
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                    Forms\Components\TextInput::make('password_confirmation')
                        ->label(__('admin.password_confirmation'))
                        ->password()
                        ->required()
                        ->rule(Password::default())
                        ->visibleOn('create'),
                    FilamentBase\Forms\DatetimeForHumans::make('password_updated_at')
                        ->label(__('admin.last_update_password_at'))
                        ->visibleOn('view'),
                    FilamentBase\Forms\DatetimeForHumans::make('last_login_at')
                        ->label(__('admin.last_login_at'))
                        ->visibleOn('view'),
                    FilamentBase\Forms\ToggleIsActive::make(__('admin.active_can_login_to_admin_panel'))
                        ->columnSpanFull()
                        ->disabled(fn ($record) => $record?->id == user_id('admin')),
                ]),
            Forms\Components\Section::make(__('admin.roles'))
                ->schema([
                    Forms\Components\CheckboxList::make('roles')
                        ->hiddenLabel()
                        ->columnSpanFull()
                        ->relationship('roles', 'name', fn ($query) => //
                            $query->take(config('base.records_limit.roles')),
                        )
                        ->disabled(fn ($record) => $record?->id == user_id('admin')),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('updated_at', 'desc')
            ->columns([
                FilamentBase\Columns\ActiveIcon::make(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('admin.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('admin.email'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label(__('admin.role'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_login_at')
                    ->label(__('admin.last_login_at'))
                    ->sortable(),
                FilamentBase\Columns\CreatedAt::make(),
                FilamentBase\Columns\UpdatedAt::make(),
            ])
            ->filters([
                FilamentBase\Filters\TernaryActiveStatusFilter::make(),
                Tables\Filters\SelectFilter::make('roles')
                    ->label(__('admin.roles'))
                    ->relationship('roles', 'name'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                // FilamentBase\Actions\CancelBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'view' => Pages\ViewAdmin::route('/{record}'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }
}
