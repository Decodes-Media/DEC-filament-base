<?php

namespace App\FilamentAdmin\Resources;

use App\Filament\MyActions;
use App\Filament\MyColumns;
use App\Filament\MyFilters;
use App\Filament\MyForms;
use App\FilamentAdmin\Resources\RoleResource\Pages;
use App\Models\Base\Permission;
use App\Models\Base\Role;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
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
        return __('Access');
    }

    public static function getModelLabel(): string
    {
        return __('Role');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Roles');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            MyForms\CreatorEditorPlaceholder::make(),
            Forms\Components\Section::make(__('Role'))
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label(__('Name'))
                        ->columnSpanFull()
                        ->required()
                        ->unique(ignoreRecord: true),
                    Forms\Components\Hidden::make('guard_name')
                        ->default('admin'),
                ]),
            Forms\Components\Section::make(__('Users'))
                ->schema([
                    Forms\Components\Select::make('users')
                        ->label(__('Attach to'))
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
            Forms\Components\Section::make(__('Access'))
                ->columns(2)
                ->schema(array_merge(
                    [
                        Forms\Components\Fieldset::make('all_fieldset')
                            ->label(__('Special Access'))
                            ->columns(1)
                            ->statePath(null)
                            ->extraAttributes(['class' => 'text-primary-600'])
                            ->schema([
                                Forms\Components\Checkbox::make('permissions.god_mode')
                                    ->label(__('SUPERADMIN - ALL ACCESS'))
                                    ->helperText(__('Special permission to override all permissions.'))
                                    ->formatStateUsing(fn ($state) => boolval($state))
                                    ->reactive(),
                            ]),
                    ],
                    static::getGroupedPermissions()->map(fn ($permissions, $group) => //
                        Forms\Components\Fieldset::make($group.'.fieldset')
                            ->label(__('Access').' — '.__(ucwords($group)))
                            ->columns(['lg' => 2, 'xl' => 3])
                            ->statePath(null)
                            ->visible(fn ($get) => ! boolval($get('permissions.god_mode')))
                            ->extraAttributes(['class' => 'text-primary-600'])
                            ->schema($permissions->map(fn ($permission) => //
                                Forms\Components\Checkbox::make('permissions.'.base64_encode($permission->name))
                                    ->label(__($permission->description))
                                    ->formatStateUsing(fn ($state) => boolval($state))
                                    ->extraAttributes(['class' => 'text-primary-600'])
                                    ->reactive()
                                    ->afterStateUpdated(function ($component, $get, $set) {
                                        $name = base64_decode(str_replace(
                                            'data.permissions.', '', $component->getStatePath(),
                                        ));
                                        if ($component->getState() && str_contains($name, '*')) {
                                            static::getGroupedPermissions()
                                                ->get(substr($name, 0, -2))
                                                ->each(fn ($p) => $set('permissions.'.base64_encode($p->name), true));
                                        }
                                    }),
                            )->toArray()),
                    )->toArray(),
                ))->afterStateHydrated(function ($context, $record, $set) {
                    if ($context == 'view' || $context == 'edit') {
                        foreach ($record->permissions as $p) {
                            $column = $p->name == '*'
                                ? 'permissions.god_mode'
                                : 'permissions.'.base64_encode($p->name);
                            $set($column, true);
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
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('users_count')
                    ->label(__('Attached to'))
                    ->suffix(' '.strtolower(__('User')))
                    ->counts('users')
                    ->sortable(),
                Tables\Columns\TextColumn::make('permissions_count')
                    ->label(__('Total permissions'))
                    ->suffix(' '.strtolower(__('Access')))
                    ->counts('permissions')
                    ->sortable(),
                MyColumns\CreatedAt::make(),
                MyColumns\UpdatedAt::make(),
            ])
            ->filters([
                MyFilters\TernaryHasRelationFilter::make('users', __('Attached to admins')),
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
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'view' => Pages\ViewRole::route('{record}'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }

    protected static function getGroupedPermissions(): Collection
    {
        return Permission::all()
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
                $permissions[] = $key == 'god_mode' ? '*' : base64_decode((string) $key);
            }
        }

        $data['permissions'] = $permissions;

        return $data;
    }
}
