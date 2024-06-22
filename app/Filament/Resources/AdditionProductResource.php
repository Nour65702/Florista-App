<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdditionProductResource\Pages;
use App\Filament\Resources\AdditionProductResource\RelationManagers;
use App\Models\AdditionProduct;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdditionProductResource extends Resource
{
    protected static ?string $model = AdditionProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
              
                    Select::make('product_id')
                    ->label('Product')
                    ->relationship(name: 'product', titleAttribute: 'name')
                    ->searchable()
                    ->preload(),
                    Select::make('addition_id')
                    ->label('Type')
                    ->relationship(name: 'addition', titleAttribute: 'name')
                    ->searchable()
                    ->preload(),
            
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('addition_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdditionProducts::route('/'),
            'create' => Pages\CreateAdditionProduct::route('/create'),
            'edit' => Pages\EditAdditionProduct::route('/{record}/edit'),
        ];
    }
}
