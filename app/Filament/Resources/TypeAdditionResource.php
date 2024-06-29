<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TypeAdditionResource\Pages;
use App\Filament\Resources\TypeAdditionResource\RelationManagers;
use App\Models\TypeAddition;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TypeAdditionResource extends Resource
{
    protected static ?string $model = TypeAddition::class;

    protected static ?string $navigationIcon = 'heroicon-m-list-bullet';
    protected static ?string $label = 'Addition Types';
    protected static ?string $navigationGroup = 'Shop';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                ->schema([
                    Section::make('Type Name')
                    ->schema([
                        TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    ])
                ])
               
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
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
            'index' => Pages\ListTypeAdditions::route('/'),
            'create' => Pages\CreateTypeAddition::route('/create'),
            'edit' => Pages\EditTypeAddition::route('/{record}/edit'),
        ];
    }
}
