<?php

namespace App\Filament\HR\Resources;

use App\Filament\HR\Resources\EmployeeResource\Pages;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-m-user-group';
    protected static ?string $navigationGroup = 'Employee Management';
    protected static ?int $navigationSort = 1;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Employee Info')

                        ->schema([
                            Select::make('user_id')
                                ->relationship(name: 'user', titleAttribute: 'name')
                                ->searchable()
                                ->preload()
                                ->default(null),
                            Select::make('branch_id')
                                ->relationship(name: 'branch', titleAttribute: 'branch_name')
                                ->searchable()
                                ->preload()
                                ->default(null),
                            Select::make('employee_type')
                                ->options([
                                    'hr' => 'HR',
                                    'accounting' => 'Accounting',
                                    'provider' => 'Provider',
                                ])
                                ->required(),

                            TextInput::make('first_name')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('last_name')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('email')
                                ->email()
                                ->required()
                                ->maxLength(255),
                            DatePicker::make('date_of_birth'),
                            DatePicker::make('date_of_joining'),
                            TextInput::make('phone')
                                ->required()
                                ->tel()
                                ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                            Select::make('gender')
                                ->options([
                                    'female' => 'Female',
                                    'male' => 'Male'
                                ])
                                ->required()

                        ])->columns(3),
                    Section::make('Employee Address')
                        ->schema([
                            Repeater::make('address')
                                ->relationship()
                                ->schema([
                                    TextInput::make('city')
                                        ->required()
                                        ->maxLength(255)
                                        ->columnSpan(5),

                                    Select::make('country_id')
                                        ->relationship(name: 'country', titleAttribute: 'name')
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->columnSpan(5),
                                    Textarea::make('line_one')
                                        ->required()
                                        ->columnSpan(5),
                                    Textarea::make('line_two')
                                        ->columnSpan(5)
                                        ->default(null),
                                    Textarea::make('street')
                                        ->required()
                                        ->columnSpanFull(),
                                ])->columns(10)

                        ]),
                    Section::make('Employee Contract')
                        ->schema([
                            Repeater::make('Contracts')
                                ->relationship()
                                ->schema([
                                    TextInput::make('city')
                                        ->required()
                                        ->maxLength(255)
                                        ->columnSpan(5),

                                    Select::make('contract_id')
                                        ->relationship(name: 'contract', titleAttribute: 'name')
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->columnSpan(5),
                                    DatePicker::make('start_date')
                                        ->required()
                                        ->columnSpan(5),
                                    DatePicker::make('end_date')
                                        ->columnSpan(5),

                                ])->columns(10)

                        ])
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('branch.branch_name')
                    ->label('Branch')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('employee_type')
                    ->label('Type')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('first_name')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable(),
                TextColumn::make('date_of_joining')
                    ->date()
                    ->sortable(),
                TextColumn::make('phone')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('gender'),
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
                SelectFilter::make('user')
                    ->relationship('user', 'name'),
                SelectFilter::make('branch')
                    ->relationship('branch', 'branch_name')
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    ViewAction::make(),
                    DeleteAction::make()
                ]),

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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
