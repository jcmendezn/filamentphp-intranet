<?php

namespace App\Filament\Personal\Resources\TimeSheets\Pages;

use App\Filament\Personal\Resources\TimeSheets\TimeSheetResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateTimeSheet extends CreateRecord
{
    protected static string $resource = TimeSheetResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;
        
        return $data;
    }      
}
