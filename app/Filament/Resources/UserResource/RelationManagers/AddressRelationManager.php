<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;


class AddressRelationManager extends RelationManager
{
    protected static string $relationship = 'address';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Address Details')
                ->schema([

                    Forms\Components\TextInput::make('city')
                        ->required()
                        ->maxLength(255),
                        Select::make('country_id')
                        ->relationship(name: 'country', titleAttribute: 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                        TextInput::make('line_one')
                        ->maxLength(255),
                        TextInput::make('line_two')
                        ->maxLength(255),
                        TextInput::make('street')
                        ->maxLength(255),
                ])->columns(3),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('city'),
                Tables\Columns\TextColumn::make('country.name'),
                Tables\Columns\TextColumn::make('line_one'),
                Tables\Columns\TextColumn::make('line_two'),
                Tables\Columns\TextColumn::make('street'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
               // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
