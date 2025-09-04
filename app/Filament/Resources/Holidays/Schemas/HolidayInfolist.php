<?php

namespace App\Filament\Resources\Holidays\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class HolidayInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('calendar_id')
                    ->numeric(),
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('day')
                    ->date(),
                TextEntry::make('type'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
