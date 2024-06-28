<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\LeaveResource\Pages;
use App\Filament\User\Resources\LeaveResource\RelationManagers;
use App\Models\Leave;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class LeaveResource extends Resource
{
    protected static ?string $model = Leave::class;

    protected static ?string $navigationIcon = 'heroicon-m-globe-alt';
    protected static ?string $navigationGroup = 'My Leaves';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Leave Information')
                            ->schema([
                                Hidden::make('employee_id')
                                    ->default(fn () => Auth::id()),
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
                            ]),

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
                    ->numeric()
                    ->sortable(),
                TextColumn::make('employee.workInfos.business_email')
                    ->label('Business Email')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('from_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('to_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('status'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected static function getTableQuery(): Builder
    {
        return parent::getTableQuery()->where('employee_id', Auth::id());
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
