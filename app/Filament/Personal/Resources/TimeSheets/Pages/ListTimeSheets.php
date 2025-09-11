<?php

namespace App\Filament\Personal\Resources\TimeSheets\Pages;

use App\Filament\Personal\Resources\TimeSheets\TimeSheetResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
//use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth;
use App\Models\TimeSheet;
use App\Models\User;
use Carbon\Carbon;
use Filament\Notifications\Notification;


class ListTimeSheets extends ListRecords
{
    protected static string $resource = TimeSheetResource::class;


    protected function getHeaderActions(): array
    {
        $lastTimeSheet = TimeSheet::where('user_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->first();

            if ($lastTimeSheet == null) {
                return [
            Action::make('inWork')
                ->label('Entrar a trabajar')
                ->icon('heroicon-o-clock')
                ->color('success')
                ->requiresConfirmation()
                ->action(function () {
                    $user = Auth::user();
                    $timeSheet = new TimeSheet();
                    $timeSheet->calendar_id = 1; 
                    $timeSheet->user_id = $user->id;
                    $timeSheet->day_in = Carbon::now();
                    $timeSheet->type = 'work';
                    $timeSheet->save();

                },
                )
                ->after(fn () => $this->redirect(\App\Filament\Personal\Resources\TimeSheets\TimeSheetResource::getUrl('index'))),
                CreateAction::make(),

            ];
            }

        return [
            
            Action::make('inWork')
                ->label('Entrar a trabajar')
                ->icon('heroicon-o-clock')
                ->color('success')
                ->visible($lastTimeSheet->day_out !== null)
                ->disabled(false)
                ->requiresConfirmation()
                ->action(function () {
                    $user = Auth::user();
                    $timeSheet = new TimeSheet();
                    $timeSheet->calendar_id = 1; 
                    $timeSheet->user_id = $user->id;
                    $timeSheet->day_in = Carbon::now();
                    $timeSheet->type = 'work';
                    $timeSheet->save();

                Notification::make()
                ->title('Has entrado a trabajar')
                ->color('success')
                ->send();

                })
                ->after(fn () => $this->redirect(\App\Filament\Personal\Resources\TimeSheets\TimeSheetResource::getUrl('index')))
                
                ,
            Action::make('stopWork')
                ->label('Parar de trabajar')
                ->icon('heroicon-o-clock')
                ->color('success')
                ->visible($lastTimeSheet->day_out == null && $lastTimeSheet->type != 'pause')
                ->disabled($lastTimeSheet->day_out !== null)
                
                ->requiresConfirmation()
                ->action(function () use ($lastTimeSheet) {
                    $lastTimeSheet->day_out = Carbon::now();
                    $lastTimeSheet->save();

                Notification::make()
                ->title('Has parado de trabajar')
                ->color('success')
                ->send();          

                })
               ->after(fn () => $this->redirect(\App\Filament\Personal\Resources\TimeSheets\TimeSheetResource::getUrl('index'))),

               Action::make('inPause')
                ->label('Comenzar pausa')
                ->icon('heroicon-o-pause')
                ->color('info')
                ->visible($lastTimeSheet->day_out == null && $lastTimeSheet->type != 'pause')
                ->disabled($lastTimeSheet->day_out !== null)
                ->requiresConfirmation()
                ->action(function () use ($lastTimeSheet) {
                    $lastTimeSheet->day_out = Carbon::now();
                    $lastTimeSheet->save();
                    
                    $timeSheet = new TimeSheet();
                    $timeSheet->calendar_id = 1; 
                    $timeSheet->user_id = Auth::user()->id;
                    $timeSheet->day_in = Carbon::now();
                    $timeSheet->type = 'pause';
                    $timeSheet->save();

                    
                    Notification::make()
                    ->title('Has inciado la pausa')
                    ->color('info')
                    ->send();          

                })
                ->after(fn () => $this->redirect(\App\Filament\Personal\Resources\TimeSheets\TimeSheetResource::getUrl('index')))
                ,
            Action::make('stopPause')
                ->label('Detener pausa')
                ->icon('heroicon-o-pause')
                ->color('info')
                ->visible($lastTimeSheet->day_out == null && $lastTimeSheet->type == 'pause')
                ->disabled($lastTimeSheet->day_out !== null)
                ->requiresConfirmation()
                ->action(function () use ($lastTimeSheet) {
                    $lastTimeSheet->day_out = Carbon::now();
                    $lastTimeSheet->save();
                    
                    $timeSheet = new TimeSheet();
                    $timeSheet->calendar_id = 1; 
                    $timeSheet->user_id = Auth::user()->id;
                    $timeSheet->day_in = Carbon::now();
                    $timeSheet->type = 'work';
                    $timeSheet->save();


                    Notification::make()
                    ->title('Has iniciado a trabajar de nuevo')
                    ->color('info')
                    ->send();          


                })
                ->after(fn () => $this->redirect(\App\Filament\Personal\Resources\TimeSheets\TimeSheetResource::getUrl('index')))
            ,
            CreateAction::make()
            ->color('info'),
        ];
    }

}
