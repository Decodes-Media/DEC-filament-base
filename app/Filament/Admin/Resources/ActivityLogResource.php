<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ActivityLogResource\Pages;
use App\Models\Base\ActivityLog;
use App\Support\FilamentBase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Relations\Relation;

class ActivityLogResource extends Resource
{
    protected static ?string $model = ActivityLog::class;

    protected static ?string $slug = 'system/log-activity';

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('permission.system');
    }

    public static function getNavigationLabel(): string
    {
        return __('permission.log_activity');
    }

    public static function getModelLabel(): string
    {
        return __('permission.log_activity');
    }

    public static function getPluralModelLabel(): string
    {
        return __('permission.log_activities');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make(__('admin.activity'))
                ->columns(3)
                ->schema([
                    Forms\Components\Placeholder::make('created_at')
                        ->label(__('admin.action_at'))
                        ->content(fn ($record) => //
                            $record->created_at.' ('.$record->created_at->diffForHumans().')',
                        ),
                    Forms\Components\Placeholder::make('event')
                        ->label(__('admin.event'))
                        ->content(fn ($record) => strtoupper($record->event) ?: '-'),
                    Forms\Components\Placeholder::make('')
                        ->label(__('admin.description'))
                        ->content(fn ($record) => $record->description ?: '-'),
                ]),
            Forms\Components\Section::make(__('admin.actor'))
                ->columns(3)
                ->schema([
                    Forms\Components\Placeholder::make('causer_type')
                        ->label(__('admin.causer_type'))
                        ->content(fn ($record) => $record->causer_type_fmt ?: '-'),
                    Forms\Components\Placeholder::make('causer_id')
                        ->label(__('admin.causer_id'))
                        ->content(fn ($record) => $record->causer_id ?: '-'),
                    Forms\Components\Placeholder::make('causer name')
                        ->label(__('admin.causer_name'))
                        ->content(fn ($record) => $record->causer?->name ?: '-'),
                    Forms\Components\Placeholder::make('subject_type')
                        ->label(__('admin.subject_type'))
                        ->content(fn ($record) => $record->subject_type_fmt ?: '-'),
                    Forms\Components\Placeholder::make('subject_id')
                        ->label(__('admin.subject_id'))
                        ->content(fn ($record) => $record->subject_id ?: '-'),
                    Forms\Components\Placeholder::make('subject_name')
                        ->label(__('admin.subject_name'))
                        ->content(fn ($record) => //
                            method_exists((object) $record->subject, 'logIdentifier')
                                ? $record->subject?->logIdentifier()
                                : ($record->subject?->name ?: $record->subject?->id ?: '-')
                        ),
                ]),
            Forms\Components\Section::make(__('admin.metadata'))
                ->schema([
                    Forms\Components\KeyValue::make('properties.attributes')
                        ->label(__('admin.new_attributes')),
                    Forms\Components\KeyValue::make('properties.old')
                        ->label(__('admin.old_attributes')),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'DESC')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('admin.id'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('admin.action_at'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('log_name')
                    ->wrap(true)
                    ->label(__('admin.log_type'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('event')
                    ->label(__('admin.event_name'))
                    ->formatStateUsing(fn ($record) => strtoupper($record->event))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('causer_type')
                    ->label(__('admin.causer_type'))
                    ->getStateUsing(fn ($record) => $record->causer_type_fmt)
                    ->default('-')
                    ->sortable(),
                Tables\Columns\TextColumn::make('causer.name')
                    ->label(__('admin.causer_name'))
                    ->default('-')
                    ->sortable(),
                Tables\Columns\TextColumn::make('subject_type')
                    ->getStateUsing(fn ($record) => $record->subject_type_fmt)
                    ->label(__('admin.subject_type'))
                    ->default('-')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('log_name')
                    ->label(__('admin.log_type'))
                    ->options(array_mirror(
                        ActivityLog::query()
                            ->selectRaw('distinct log_name as x')
                            ->pluck('x')
                    ))->multiple(),
                Tables\Filters\SelectFilter::make('event')
                    ->label(__('admin.event_name'))
                    ->options(array_mirror(
                        ActivityLog::query()
                            ->selectRaw('distinct event as x')
                            ->pluck('x')
                            ->map(fn ($x) => strtoupper($x))
                    ))->multiple(),
                Tables\Filters\SelectFilter::make('causer_type')
                    ->label(__('admin.causer_type'))
                    ->options(array_mirror(
                        ActivityLog::query()
                            ->selectRaw('distinct causer_type as x')
                            ->pluck('x')
                    ))->multiple(),
                Tables\Filters\SelectFilter::make('causer_id')
                    ->label(__('admin.causer_name'))
                    ->options(fn () => ActivityLog::query()
                        ->selectRaw('distinct causer_id, causer_type')
                        ->pluck('causer_type', 'causer_id')
                        ->reject(fn ($x) => empty($x))
                        ->map(function ($type, $id) {
                            //
                            $model = Relation::getMorphedModel($type);
                            $record = $model ? $model::find($id) : null;

                            if (method_exists((object) $record, 'logIdentifier')) {
                                return $record->logIdentifier();
                            }

                            return $record ? ($record->name ?: $record->id ?: '') : '';
                        })
                    )->multiple(),
                Tables\Filters\SelectFilter::make('subject_type')
                    ->label(__('admin.subject_type'))
                    ->options(array_mirror(
                        ActivityLog::query()
                            ->selectRaw('distinct subject_type as x')
                            ->pluck('x'),
                    ))->multiple(),
                FilamentBase\Filters\DateRangeBasicFilter::make(
                    'created_at',
                    __('admin.action_date_from'),
                    __('admin.action_date_until'),
                ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('')->icon(''),
            ])
            ->bulkActions([
                // FilamentBase\Actions\CancelBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityLogs::route('/'),
            'view' => Pages\ViewActivityLog::route('/{record}'),
        ];
    }
}
