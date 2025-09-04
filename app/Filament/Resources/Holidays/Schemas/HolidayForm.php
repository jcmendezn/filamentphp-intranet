<?php

namespace App\Filament\Resources\Holidays\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class HolidayForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('calendar_id')
                    ->required()
                    ->numeric(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                DatePicker::make('day')
                    ->required(),
                Select::make('type')
                    ->options(['decline' => 'Decline', 'approved' => 'Approved', 'pending' => 'Pending'])
                    ->default('pending')
                    ->required(),
            ]);
    }
}
