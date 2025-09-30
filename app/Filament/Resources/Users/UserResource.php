<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\State;
use App\Models\City; 
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get as Get;
use Filament\Schemas\Components\Utilities\Set as Set;

use function Laravel\Prompts\table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?int $navigationSort = 2;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static string|\UnitEnum|null $navigationGroup = 'Employee Management';

public static function form(Schema $schema): Schema
    {
        //return UserForm::configure($schema);
        //public static function form(Form $form): Form
    return $schema
        ->schema([

            Section::make('Informacion Personal')
            ->description('Información del empleado')
            ->columns(3)
            ->columnSpanFull()
            ->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nombre')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('email')
                ->label('Correo electrónico')
                ->email()
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('password')
                ->label('Contraseña')
                ->password()
                ->hiddenOn('edit')
                ->required(fn (string $operation) => $operation === 'create')
                ->maxLength(255),

            ]),            
            Section::make('Dirección')
            ->description('Información del dirección')
            ->columns(3)
            ->columnSpanFull()
            ->schema([
            Forms\Components\Select::make('country_id')
                ->relationship(name: 'country',titleAttribute: 'name')
                ->searchable()
                ->preload()
                ->live()
                ->afterStateUpdated(function (Set $set){
                    $set('state_id', null);
                    $set('city_id', null);
                    })
                ->required(),

            Forms\Components\Select::make('state_id')
                ->options(fn(Get $get): array => State::query()
                    ->where('country_id', $get('country_id'))
                    ->pluck('name', 'id')
                    ->toArray()
                    )
                ->searchable()
                ->preload()
                ->live()
                ->afterStateUpdated(function (Set $set){
                    $set('city_id', null);
                    })                
                ->required(),

             Forms\Components\Select::make('city_id')
                ->options(fn(Get $get): array => City::query()
                    ->where('state_id', $get('state_id'))
                    ->pluck('name', 'id')
                    ->toArray()
                    )
                ->searchable()
                ->preload()
                ->live()
                ->required(), 
            Forms\Components\TextInput::make('address')
                ->required(),                
            Forms\Components\TextInput::make('postal_code')
                ->required(),           
            Forms\Components\Select::make('roles')
                ->label('Roles')
                ->relationship('roles', 'name') // Relación con spatie/laravel-permission
                ->multiple()
                ->preload()
                ->searchable(),                     


            ]),

        
        ]);
    }

    public static function table(Table $table): Table
    {
        //return UsersTable::configure($table);
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Correo electrónico')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label('Correo electrónico verificado')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('country.name')
                    ->label('País')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('state.name')
                    ->label('Departamento')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('city.name')
                    ->label('Municipio')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('address')
                    ->label('Dirección')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('postal_code')
                    ->label('Código Postal')
                    ->searchable()
                    ->sortable(),
/*
            Tables\Columns\TextColumn::make('roles.name')
                ->label('Roles')
                ->badge(),                    */
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
