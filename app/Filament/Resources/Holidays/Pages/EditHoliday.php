<?php

namespace App\Filament\Resources\Holidays\Pages;

use App\Filament\Resources\Holidays\HolidayResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\HolidayApproved;
use App\Mail\HolidayDecline;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;

class EditHoliday extends EditRecord
{
    protected static string $resource = HolidayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record -> update($data);
        
        //send email if type is approved
        if ($data['type'] == 'approved') {
            $user = User::find($record->user_id);
            $data = array(
                'name' => $user->name,
                'email' => $user->email,
                'day' => $record->day,
            );

            Mail::to($user)->send(new HolidayApproved($data));

            $recipient = $user;

            Notification::make()
                ->title('Solicitud de vacaciones APROBADA')
                ->body('El dia ' . $data['day'] . ' ha sido aprobado.')
                ->success()        
                ->sendToDatabase($recipient);

    }  
    else if ($data['type'] == 'decline') {
        //send email if type is decline
        $user = User::find($record->user_id);
        $data = array(
            'name' => $user->name,
            'email' => $user->email,
            'day' => $record->day,
        );

        Mail::to($user)->send(new HolidayDecline($data));

        $recipient = $user; 

        Notification::make()
            ->title('Solicitud de vacaciones Rechazada')
            ->body('El dia ' . $data['day'] . ' ha sido rechazado.')
            ->warning()        
            ->sendToDatabase($recipient);

    }

        return $record;
}
}

