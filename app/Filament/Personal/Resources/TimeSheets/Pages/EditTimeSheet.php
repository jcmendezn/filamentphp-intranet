<?php

namespace App\Filament\Personal\Resources\TimeSheets\Pages;

use App\Filament\Personal\Resources\TimeSheets\TimeSheetResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTimeSheet extends EditRecord
{
    protected static string $resource = TimeSheetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
