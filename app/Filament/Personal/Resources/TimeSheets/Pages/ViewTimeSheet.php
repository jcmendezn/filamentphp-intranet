<?php

namespace App\Filament\Personal\Resources\TimeSheets\Pages;

use App\Filament\Personal\Resources\TimeSheets\TimeSheetResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTimeSheet extends ViewRecord
{
    protected static string $resource = TimeSheetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
