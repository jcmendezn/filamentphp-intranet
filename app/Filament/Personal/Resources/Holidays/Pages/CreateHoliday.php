<?php

namespace App\Filament\Personal\Resources\Holidays\Pages;

use App\Filament\Personal\Resources\Holidays\HolidayResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\HolidayPending;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;

class CreateHoliday extends CreateRecord
{
    protected static string $resource = HolidayResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;
        $data['type'] = 'pending';

        $userAdmin = User::find(1);

        $dataToSend = [
            'day' => $data['day'],
            'name' => user::find($data['user_id'])->name,
            'email' => user::find($data['user_id'])->email,
        ];
        Mail::to($userAdmin)->send(new HolidayPending($dataToSend));


/*         Notification::make()
        ->title('Solicitud de vacaciones enviada correctamente')
        ->body('El dia ' . $data['day'] . ' ha sido enviado para su aprobacion.')
        ->warning()
        ->send(); */

    //$recipient = auth()->user();
    //$user = Filament::auth()->user(); 
    //$recipient = auth()->$user();

    $recipient = Filament::auth()->user(); 

    Notification::make()
        ->title('Solicitud de vacaciones enviada correctamente')
        ->body('El dia ' . $data['day'] . ' ha sido enviado para su aprobacion.')
        ->warning()        
        ->sendToDatabase($recipient);

        return $data;
    }    




}

