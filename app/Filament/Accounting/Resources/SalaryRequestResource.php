<?php

namespace App\Filament\Accounting\Resources;

use App\Filament\Accounting\Resources\SalaryRequestResource\Pages;
use App\Models\SalaryRequest;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class SalaryRequestResource extends Resource
{
    protected static ?string $model = SalaryRequest::class;

    protected static ?string $navigationIcon = 'heroicon-m-document-check';
    protected static ?string $navigationGroup = 'Salaries';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
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

                SelectColumn::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                    ])
                    ->searchable()
                    ->sortable(),
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
                //   EditAction::make(),
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
