<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProviderLicenceResource\Pages;
use App\Filament\Resources\ProviderLicenceResource\RelationManagers;
use App\Models\Provider;
use App\Models\ProviderLicence;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\View\Components\Modal;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ButtonAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProviderLicenceResource extends Resource
{
    protected static ?string $model = ProviderLicence::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {


        return $form;


    }

    public static function table(Table $table): Table
    {
        $loggedInUserId = auth()->id();
        $providerIdValue = $loggedInUserId ? (string) $loggedInUserId : '';
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('provider_id')
                    ->numeric()
                    ->sortable()
                    ->default($providerIdValue)
                    ->disabled($loggedInUserId ? true : false),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
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
                EditAction::make(),
                Action::make('Accept')
                ->button()
               // ->onClick(fn ($record) => $record->update(['is_active' => true]))
                ->visible(fn ($record) => !$record->is_active),
            Action::make('Reject')
                ->button()
               // ->onClick(fn ($record) => $record->delete())
                ->visible(fn ($record) => !$record->is_active),


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
            'index' => Pages\ListProviderLicences::route('/'),
            'create' => Pages\CreateProviderLicence::route('/create'),
            'edit' => Pages\EditProviderLicence::route('/{record}/edit'),
        ];
    }
}
