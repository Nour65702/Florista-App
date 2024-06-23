<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserCustomBouquetsResource\Pages;
use App\Filament\Resources\UserCustomBouquetsResource\RelationManagers;
use App\Models\UserCustomBouquets;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserCustomBouquetsResource extends Resource
{
    protected static ?string $model = UserCustomBouquets::class;

    protected static ?string $navigationIcon = 'heroicon-m-fire';
    public static ?string $label = 'Bouquets';
    protected static ?string $navigationGroup = 'Customer Bouquets';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('design_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('color_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('total_price')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('design.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('color.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_price')
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
            'index' => Pages\ListUserCustomBouquets::route('/'),
            'create' => Pages\CreateUserCustomBouquets::route('/create'),
            'edit' => Pages\EditUserCustomBouquets::route('/{record}/edit'),
        ];
    }
}
