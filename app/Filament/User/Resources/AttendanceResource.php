<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\AttendanceResource\Pages;
use App\Filament\User\Resources\AttendanceResource\RelationManagers;
use App\Models\Attendance;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Support\Facades\Auth;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-m-finger-print';
    protected static ?string $navigationGroup = 'Record Attendance';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Attendance Details')
                    ->schema([
                        Hidden::make('employee_id')
                            ->default(fn() => Auth::id()),

                        TimePicker::make('check_in')
                            ->label('Check In Time')
                            
                            ->dehydrated(false)
                            ->required(),

                        TimePicker::make('check_out')
                            ->label('Check Out Time')
                           
                            ->dehydrated(false)
                            ->required(),

                      

                            

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

                TextColumn::make('check_in')
                    ->sortable()
                    ->formatStateUsing(fn($state) => $state ? Carbon::parse($state)->format('H:i:s') : '-'),

                TextColumn::make('check_out')
                    ->sortable()
                    ->formatStateUsing(fn($state) => $state ? Carbon::parse($state)->format('H:i:s') : '-'),

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

                TextColumn::make('date')
                    ->date()
                    ->sortable(),

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
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}
