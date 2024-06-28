<?php

namespace App\Filament\HR\Resources;

use App\Filament\HR\Resources\LeaveResource\Pages;
use App\Filament\HR\Resources\LeaveResource\RelationManagers;
use App\Models\Leave;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LeaveResource extends Resource
{
    protected static ?string $model = Leave::class;

    protected static ?string $navigationIcon = 'heroicon-m-rocket-launch';
    protected static ?string $navigationGroup = 'Vacations';
    protected static ?int $navigationSort = 4;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Leave Information')
                            ->schema([
                                Select::make('employee_id')
                                    ->relationship(name: 'employee', titleAttribute: 'first_name')
                                    ->searchable()
                                    ->preload(),
                                Select::make('type_id')
                                    ->relationship(name: 'leaveType', titleAttribute: 'type')
                                    ->searchable()
                                    ->preload(),

                            ])->columns(2),

                        Section::make('Leave Date')
                            ->schema([
                                DatePicker::make('from_date')
                                    ->required(),
                                DatePicker::make('to_date')
                                    ->required(),
                            ])->columns(2),

                        Section::make('Leave Reason')
                            ->schema([
                                Textarea::make('reason')
                                    ->columnSpanFull(),
                                ToggleButtons::make('status')
                                    ->inline()
                                    ->default('pending')
                                    ->required()
                                    ->options([
                                        'pending' => 'Pending',
                                        'approved' => 'Approved',
                                        'rejected' => 'Rejected',
                                    ])->columnSpan(2)
                                    ->colors([
                                        'pending' => 'info',
                                        'approved' => 'success',
                                        'rejected' => 'danger',
                                    ])
                                    ->icons([
                                        'pending' => 'heroicon-m-sparkles',
                                        'approved' => 'heroicon-m-arrow-path',
                                        'rejected' => 'heroicon-m-x-circle',

                                    ]),
                            ])
                    ])->columnSpanFull()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('leaveType.type')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('employee.first_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('from_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('to_date')
                    ->date()
                    ->sortable(),
                SelectColumn::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->sortable()
                    ->searchable(),
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
                ActionGroup::make([
                    EditAction::make(),
                    ViewAction::make(),
                    DeleteAction::make(),
                ])
              
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count();
    }
    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::where('status', 'pending')->count() > 10 ? 'danger' : 'success';
    }
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeaves::route('/'),
            'create' => Pages\CreateLeave::route('/create'),
            'edit' => Pages\EditLeave::route('/{record}/edit'),
        ];
    }
}
