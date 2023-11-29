<?php

namespace App\FilamentAdmin\Resources;

use App\Filament\MyActions;
use App\Filament\MyColumns;
use App\Filament\MyFilters;
use App\Filament\MyForms;
use App\FilamentAdmin\Resources\AdminResource\Pages;
use App\Models\Admin;
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
        return __('Access');
    }

    public static function getModelLabel(): string
    {
        return __('Admin');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Admins');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            MyForms\CreatorEditorPlaceholder::make(),
            Forms\Components\Section::make(__('About'))
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label(__('Name'))
                        ->disabled(fn ($record, $context) => //
                            $context != 'create' && (
                                $record?->id == user_id('admin')
                                || $record?->email == config('base.superadmin_email')
                            ),
                        )
                        ->required(),
                    Forms\Components\TextInput::make('email')
                        ->label(__('Email'))
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->disabledOn('edit'),
                    Forms\Components\TextInput::make('password')
                        ->label(__('Password'))
                        ->password()
                        ->required()
                        ->confirmed()
                        ->rule(Password::default())
                        ->visibleOn('create')
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                    Forms\Components\TextInput::make('password_confirmation')
                        ->label(__('Password confirmation'))
                        ->password()
                        ->required()
                        ->rule(Password::default())
                        ->visibleOn('create'),
                    MyForms\DatetimeForHumans::make('password_updated_at')
                        ->label(__('Last update password at'))
                        ->visibleOn('view'),
                    MyForms\DatetimeForHumans::make('last_login_at')
                        ->label(__('Last login at'))
                        ->visibleOn('view'),
                    MyForms\ToggleIsActive::make(__('Active - can login to admin panel'))
                        ->columnSpanFull()
                        ->disabled(fn ($record) => $record?->id == user_id('admin')),
                ]),
            Forms\Components\Section::make(__('Roles'))
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
            ->defaultSort('updated_at', 'DESC')
            ->columns([
                MyColumns\ActiveIcon::make(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label(__('Role'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_login_at')
                    ->label(__('Last login at'))
                    ->sortable(),
                MyColumns\CreatedAt::make(),
                MyColumns\UpdatedAt::make(),
            ])
            ->filters([
                MyFilters\TernaryActiveStatusFilter::make(),
                Tables\Filters\SelectFilter::make('roles')
                    ->label(__('Roles'))
                    ->relationship('roles', 'name'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                // MyActions\CancelBulkAction::make(),
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
