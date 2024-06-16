<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Alert;
use App\Models\OrderItem;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Range;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Request;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-m-gift-top';
    protected static ?string $navigationGroup = 'System Management';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([

                    Section::make('Product Informations')
                        ->schema([

                            TextInput::make('name')
                                ->required()
                                ->maxLength(255),


                            Select::make('size')
                                ->multiple()
                                ->options([
                                    'small' => 'Small',
                                    'medium' => 'Medium',
                                    'big' => 'Big',
                                ]),
                            Textarea::make('description')
                                ->required()
                                ->columnSpanFull(),
                            TextInput::make('quantity')
                                ->required()
                                ->numeric(),
                                Forms\Components\TextInput::make('min_level')
                                ->required()
                                ->numeric(),
                        ])->columns(2)
                ])->columnSpan(2),
                Group::make()->schema([
                    Section::make('Price')
                        ->schema([
                            TextInput::make('price')
                                ->required()
                                ->numeric()
                                ->prefix('$'),
                        ]),
                    Section::make('Associations')
                        ->schema([
                            Select::make('collection_id')
                                ->relationship(name: 'collection', titleAttribute: 'name')
                                ->required()
                                ->preload()
                                ->searchable()
                        ]),
                    Section::make('Status')
                        ->schema([
                            Toggle::make('in_stock')
                                ->required()
                                ->default(true),
                            Toggle::make('on_sale')
                                ->required(),
                            Toggle::make('is_active')
                                ->required()
                                ->default(true)
                        ])
                ])->columnSpan(1)
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('collection.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('size')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->searchable(),
                TextColumn::make('rate')
                    ->summarize(Average::make()),
                IconColumn::make('in_stock')
                    ->boolean(),
                IconColumn::make('on_sale')
                    ->boolean(),
                IconColumn::make('is_active')
                    ->boolean(),


                Tables\Columns\TextColumn::make('min_level')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('triggered_at')
                    ->dateTime()
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
                SelectFilter::make('collection')
                    ->relationship('collection', 'name')
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make()
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
