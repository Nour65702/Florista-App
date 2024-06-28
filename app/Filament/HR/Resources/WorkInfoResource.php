<?php

namespace App\Filament\HR\Resources;

use App\Filament\HR\Resources\WorkInfoResource\Pages;
use App\Models\WorkInfo;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class WorkInfoResource extends Resource
{
    protected static ?string $model = WorkInfo::class;

    protected static ?string $navigationIcon = 'heroicon-m-folder';
    protected static ?string $navigationGroup = 'Employee Management';
    public static ?string $label = 'Work Information';
    protected static ?int $navigationSort = 2;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Work Informations')
                        ->schema([
                            Select::make('employee_id')
                                ->relationship(name: 'employee', titleAttribute: 'first_name')
                                ->searchable()
                                ->preload(),

                            Select::make('department_id')
                                ->relationship(name: 'department', titleAttribute: 'name')
                                ->searchable()
                                ->preload(),
                            Select::make('job_type_id')
                                ->relationship(name: 'jobType', titleAttribute: 'name')
                                ->searchable()
                                ->preload(),
                            Select::make('job_level_id')
                                ->relationship(name: 'jobLevel', titleAttribute: 'name')
                                ->searchable()
                                ->preload(),
                            Select::make('country_id')
                                ->relationship(name: 'country', titleAttribute: 'name')
                                ->searchable()
                                ->preload(),
                            TextInput::make('city')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('business_email')
                                ->email()
                                ->required()
                                ->maxLength(255),
                            TextInput::make('business_number')
                                ->required()
                                ->tel()
                                ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                        ])->columns(2),

                    Section::make('Work Experiences')
                        ->schema([
                            Repeater::make('experiences')
                                ->relationship()
                                ->schema([

                                    DatePicker::make('from_date')
                                        ->required(),
                                    DatePicker::make('to_date')
                                        ->required(),
                                    TextInput::make('company')
                                        ->required()
                                        ->maxLength(255),
                                    TextInput::make('position')
                                        ->required()
                                        ->maxLength(255),
                                ])->columns(2)
                        ]),


                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.first_name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('department.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('country.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('city')
                    ->searchable(),
                TextColumn::make('business_email')
                    ->searchable(),
                TextColumn::make('business_number')
                    ->numeric()
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
            'index' => Pages\ListWorkInfos::route('/'),
            'create' => Pages\CreateWorkInfo::route('/create'),
            'edit' => Pages\EditWorkInfo::route('/{record}/edit'),
        ];
    }
}
