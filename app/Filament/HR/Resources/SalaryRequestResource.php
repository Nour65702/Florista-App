<?php

namespace App\Filament\HR\Resources;

use App\Filament\HR\Resources\SalaryRequestResource\Pages;
use App\Filament\HR\Resources\SalaryRequestResource\RelationManagers;
use App\Models\SalaryRequest;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SalaryRequestResource extends Resource
{
    protected static ?string $model = SalaryRequest::class;

    protected static ?string $navigationIcon = 'heroicon-m-pencil-square';
    protected static ?string $navigationGroup = 'Salaries Managment';
    protected static ?int $navigationSort = 3;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Salaries Status')
                            ->schema([
                                Select::make('salary_id')
                                    ->label('Employee')
                                    ->relationship(name: 'salary.employee', titleAttribute: 'first_name')
                                    ->searchable()
                                    ->preload(),

                            ])

                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('salary.employee.first_name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('salary.amount')
                    ->numeric()
                    ->sortable()
                    ->money('SYP'),
                TextColumn::make('request_date')
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
            'index' => Pages\ListSalaryRequests::route('/'),
            'create' => Pages\CreateSalaryRequest::route('/create'),
            'edit' => Pages\EditSalaryRequest::route('/{record}/edit'),
        ];
    }
}
