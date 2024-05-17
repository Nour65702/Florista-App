<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminPanelSettingResource\Pages;
use App\Filament\Resources\AdminPanelSettingResource\RelationManagers;
use App\Models\Admin;
use App\Models\AdminPanelSetting;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;



class AdminPanelSettingResource extends Resource
{
    protected static ?string $model = AdminPanelSetting::class;

    protected static ?string $navigationIcon = 'heroicon-m-cog-6-tooth';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Company Information')
                    ->schema([

                        TextInput::make('system_name')
                            ->label('Company Name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('general_alert')
                            ->required()
                            ->maxLength(255),
                        Toggle::make('active')
                            ->default(true)
                            ->required(),
                    ])




            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('system_name')
                    ->label('Company Name')
                    ->searchable(),
                TextColumn::make('general_alert')
                    ->searchable(),
                IconColumn::make('active')
                    ->boolean(),


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
                EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function query(): Builder
    {
        return parent::query()->with('updatedByAdmin');
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
            'index' => Pages\ListAdminPanelSettings::route('/'),
            'create' => Pages\CreateAdminPanelSetting::route('/create'),
            'edit' => Pages\EditAdminPanelSetting::route('/{record}/edit'),
        ];
    }
}
