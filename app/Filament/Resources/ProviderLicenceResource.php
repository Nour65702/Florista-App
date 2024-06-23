<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProviderLicenceResource\Pages;
use App\Models\ProviderLicence;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class ProviderLicenceResource extends Resource
{
    protected static ?string $model = ProviderLicence::class;

    protected static ?string $navigationIcon = 'heroicon-m-arrow-down-tray';
    protected static ?string $navigationGroup = 'Request Providers';

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
                Tables\Columns\TextColumn::make('provider.name')
                    ->numeric()
                    ->sortable()
                    ->default($providerIdValue)
                    ->disabled($loggedInUserId ? true : false),
                TextColumn::make('provider.email')
                    ->label('Provider Email'),
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active Status'),
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
                ActionGroup::make([
                    EditAction::make(),
                ]),
                Action::make('Accept')
                    ->label('Accept')
                    ->button()
                    ->action(function ($record) {
                        $record->update(['is_active' => true]);
                    })
                    ->visible(fn ($record) => !$record->is_active),
                Action::make('Reject')
                    ->label('Reject')
                    ->button()
                    ->color('danger')
                    ->action(function ($record) {
                        $record->delete();
                    })
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

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_active', false)->count();
    }
    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::where('is_active', false)->count() > 0 ? 'danger' : 'success';
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
