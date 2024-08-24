<?php

namespace App\Filament\HR\Resources;

use App\Filament\HR\Resources\AttendanceResource\Pages;
use App\Filament\HR\Resources\AttendanceResource\RelationManagers;
use App\Models\Attendance;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-m-arrows-up-down';
    protected static ?string $navigationGroup = 'Permanence Monitoring';
    protected static ?int $navigationSort = 4;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Attendance')
                    ->schema([
                        Select::make('employee_id')
                            ->relationship(name: 'employee', titleAttribute: 'first_name')
                            ->searchable()
                            ->preload()
                            ->searchable(),
                        DatePicker::make('date')
                            ->required(),
                        TextInput::make('check_in'),
                        TextInput::make('check_out'),

                    ])->columns(2)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.first_name')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('check_in'),
                TextColumn::make('check_out'),
                TextColumn::make('duration')
                    ->label('Duration')
                    ->getStateUsing(function ($record) {
                        if ($record->check_in && $record->check_out) {
                            $checkIn = Carbon::parse($record->check_in);
                            $checkOut = Carbon::parse($record->check_out);
                            $diff = $checkIn->diff($checkOut);
                            return $diff->format('%H:%I:%S');
                        }
                        return '-';
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}
