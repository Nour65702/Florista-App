<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdditionResource\Pages;
use App\Filament\Resources\AdditionResource\RelationManagers;
use App\Models\Addition;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdditionResource extends Resource
{
    protected static ?string $model = Addition::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('')
                            ->schema([
                                Select::make('type_addition_id')
                                    ->label('Type')
                                    ->relationship(name: 'typeAddition', titleAttribute: 'name')
                                    ->searchable()
                                    ->preload(),
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('price')
                                    ->required()
                                    ->numeric()
                                    ->prefix('$'),
                                TextInput::make('quantity')
                                    ->numeric()
                                    ->required()
                                    ->default(1)
                                    ->minValue(1)
                                    ->reactive(),
                                Textarea::make('description')
                                    ->nullable(),
                                // ->columnSpanFull(),
                                SpatieMediaLibraryFileUpload::make('addition_image')
                                    ->required()
                                    ->collection('images')
                            ])->columns(2),

                    ])->columnSpanFull(),

                Group::make()
                    ->schema([
                        Section::make('Product Additions')
                            ->schema([
                                Repeater::make('productAdditions')
                                    ->relationship()
                                    ->schema([

                                        Select::make('product_id')
                                            ->relationship('product', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->distinct()
                                            ->columnSpan(4)
                                            ->reactive(),

                                    ])
                            ])
                    ]),
                Group::make()
                    ->schema([
                        Section::make('Bouquet Additions')
                            ->schema([
                                Repeater::make('bouquetAdditions')
                                    ->relationship()
                                    ->schema([

                                        Select::make('bouquet_product_id')
                                            ->relationship('bouquetProduct.bouquet', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->distinct()
                                            ->columnSpan(4)
                                            ->reactive(),
                                        TextInput::make('quantity')
                                            ->numeric()
                                            ->required()
                                            ->default(1)
                                            ->minValue(1)
                                            ->reactive(),
                                    ])
                            ])
                    ])


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('addition_image')
                    ->collection('images'),
                TextColumn::make('typeAddition.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('description')
                    ->searchable(),
                TextColumn::make('price')
                    ->money()
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
            'index' => Pages\ListAdditions::route('/'),
            'create' => Pages\CreateAddition::route('/create'),
            'edit' => Pages\EditAddition::route('/{record}/edit'),
        ];
    }
}
