<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-m-pencil-square';
    protected static ?string $navigationGroup = 'Request Providers';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Task To')
                        ->schema([

                            Select::make('provider_id')
                                ->relationship('provider', 'name')
                                ->required(),
                            Select::make('order_id')
                                ->relationship('order', 'id')
                                ->required(),
                        ])->columns(2),
                    Section::make('Task Information')
                        ->schema([

                            TextInput::make('title')
                                ->required()
                                ->maxLength(255),
                            DateTimePicker::make('due_date')
                                ->required()
                                ->native(false),
                            Textarea::make('description')
                                ->required()
                                ->columnSpanFull(),

                            ToggleButtons::make('priority')
                                ->inline()
                                ->default('medium')
                                ->required()
                                ->options([
                                    'low' => 'Low',
                                    'medium' => 'Medium',
                                    'high' => 'High',
                                ])
                                ->colors([
                                    'low' => 'info',
                                    'medium' => 'warning',
                                    'high' => 'danger',
                                ]),
                            Toggle::make('completed')
                                ->default(false)
                                ->onColor('success')
                                ->required()

                        ])->columns(2)
                ])->columnSpanFull(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('provider.name')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('order.user.name')
                    ->label('From Customer')
                    ->sortable(),
                TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('due_date')
                    ->dateTime()
                    ->sortable(),
                SelectColumn::make('priority')
                    ->options([
                        'low' => 'Low',
                        'medium' => 'Medium',
                        'high' => 'High',
                    ]),

                IconColumn::make('completed')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        return  static::getModel()::where('completed', false)->count();
    }
    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::where('completed', false)->count() > 5 ? 'danger' : 'success';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
