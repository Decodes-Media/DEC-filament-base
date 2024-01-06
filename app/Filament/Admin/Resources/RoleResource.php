<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\RoleResource\Pages;
use App\Models\Base\Permission;
use App\Models\Base\Role;
use App\Support\FilamentBase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $slug = 'roles';

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?int $navigationSort = 2;

    protected static Collection $permissionsCollection;

    public static function getNavigationGroup(): ?string
    {
        return __('permission.access');
    }

    public static function getModelLabel(): string
    {
        return __('permission.role');
    }

    public static function getPluralModelLabel(): string
    {
        return __('permission.roles');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('guard_name', 'admin');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            FilamentBase\Forms\CreatorEditorPlaceholder::make(),
            Forms\Components\Section::make(__('admin.role'))
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->hiddenLabel()
                        ->columnSpanFull()
                        ->required()
                        ->unique(ignoreRecord: true),
                    Forms\Components\Hidden::make('guard_name')
                        ->default('admin'),
                ]),
            Forms\Components\Section::make(__('admin.users'))
                ->schema([
                    Forms\Components\Select::make('users')
                        ->hiddenLabel()
                        ->columnSpanFull()
                        ->relationship('users', 'name', fn ($query) => //
                            $query->take(config('base.records_limit.admins')),
                        )
                        ->multiple()
                        ->searchable()
                        ->preload()
                        ->getOptionLabelFromRecordUsing(fn ($record) => //
                            "{$record->name} — {$record->email}",
                        ),
                ]),
            Forms\Components\Section::make(__('admin.access'))
                ->columns(2)
                ->schema(array_merge(
                    [
                        Forms\Components\Fieldset::make('all_fieldset')
                            ->label(__('admin.special_access'))
                            ->columns(1)
                            ->statePath(null)
                            ->extraAttributes(['class' => 'text-primary-600'])
                            ->schema([
                                Forms\Components\Checkbox::make('permissions.Kg==')
                                    ->label(__('admin.superadmin_all_access'))
                                    ->helperText(__('admin.special_permission_to_override_all_permissions'))
                                    ->formatStateUsing(fn ($state) => boolval($state))
                                    ->reactive(),
                            ]),
                    ],
                    static::getGroupedPermissions()->map(fn ($permissions, $group) => //
                        Forms\Components\Fieldset::make($group.'.fieldset')
                            ->label(__('permission.access').' — '.__(strtolower("permission.{$group}")))
                            ->columns(['lg' => 2, 'xl' => 3])
                            ->statePath(null)
                            ->visible(fn ($get) => ! boolval($get('permissions.Kg==')))
                            ->extraAttributes(['class' => 'text-primary-600'])
                            ->schema($permissions->map(fn ($permission) => //
                                Forms\Components\Checkbox::make('permissions.'.base64_encode($permission->name))
                                    ->label(__($permission->translated_name))
                                    ->formatStateUsing(fn ($state) => boolval($state))
                                    ->extraAttributes(['class' => 'text-primary-600'])
                                    ->reactive()
                                    ->afterStateUpdated(function ($component, $get, $set) {
                                        $name = base64_decode(str_replace(
                                            'data.permissions.', '', $component->getStatePath(),
                                        ));
                                        $checked = boolval($component->getState());
                                        $permissions = static::getGroupedPermissions();
                                        if ($checked && str_contains($name, '*')) {
                                            $permissions->get(substr($name, 0, -2))
                                                ?->each(fn ($p) => $set('permissions.'.base64_encode($p->name), true));
                                        }
                                        // TODO: fix me
                                        if (! $checked && str_contains($name, '*')) {
                                            $permissions->get(substr($name, 0, -2))
                                                ?->each(fn ($p) => $set('permissions.'.base64_encode($p->name), false));
                                        }
                                    }),
                            )->toArray()),
                    )->toArray(),
                ))
                ->afterStateHydrated(function ($context, $record, $set) {
                    if ($context == 'view' || $context == 'edit') {
                        $permissions = static::getGroupedPermissions();
                        foreach ($record->permissions as $p) {
                            $set('permissions.'.base64_encode($p->name), true);
                            if (str_contains($p->name, '*')) {
                                $permissions->get(substr($p->name, 0, -2))
                                    ?->each(fn ($p) => $set('permissions.'.base64_encode($p->name), true));
                            }
                        }
                    }
                }),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('updated_at', 'DESC')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('admin.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('users_count')
                    ->label(__('admin.attached_to'))
                    ->suffix(' '.strtolower(__('admin.user')))
                    ->counts('users')
                    ->sortable(),
                Tables\Columns\TextColumn::make('permissions_count')
                    ->label(__('admin.total_permission'))
                    ->suffix(' '.strtolower(__('admin.access')))
                    ->counts('permissions')
                    ->sortable(),
                FilamentBase\Columns\CreatedAt::make(),
                FilamentBase\Columns\UpdatedAt::make(),
            ])
            ->filters([
                FilamentBase\Filters\TernaryHasRelationFilter::make('users', __('admin.attached_to_admins')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                FilamentBase\Actions\CancelBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'view' => Pages\ViewRole::route('{record}'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }

    protected static function getGroupedPermissions(): Collection
    {
        return Permission::query()
            ->where('guard_name', 'admin')
            ->get()
            ->sortBy('display_order')
            ->groupBy(function ($item) {
                //
                $matches = [];
                preg_match_all('/.+?(?=\.)/', $item->name, $matches);

                return implode('', (array) @$matches[0]);
            })
            ->reject(fn ($permissions, $group) => blank($group));
    }

    public static function mutateDateForPermissions(array $data): array
    {
        $permissions = [];

        foreach (array_keys($data['permissions']) as $key) {
            if ($data['permissions'][$key]) {
                $permissions[] = $key == 'Kg==' ? '*' : base64_decode((string) $key);
            }
        }

        $data['permissions'] = $permissions;

        return $data;
    }
}
