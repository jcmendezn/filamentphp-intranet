<?php

namespace App\Filament\Personal\Resources\TimeSheets;

use App\Filament\Personal\Resources\TimeSheets\Pages\CreateTimeSheet;
use App\Filament\Personal\Resources\TimeSheets\Pages\EditTimeSheet;
use App\Filament\Personal\Resources\TimeSheets\Pages\ListTimeSheets;
use App\Filament\Personal\Resources\TimeSheets\Pages\ViewTimeSheet;
use App\Filament\Personal\Resources\TimeSheets\Schemas\TimeSheetForm;
use App\Filament\Personal\Resources\TimeSheets\Schemas\TimeSheetInfolist;
use App\Filament\Personal\Resources\TimeSheets\Tables\TimeSheetsTable;
use App\Models\TimeSheet;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TimeSheetResource extends Resource
{
    protected static ?string $model = TimeSheet::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTableCells;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', Auth::user()->id)->orderBy('id', 'desc');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Select::make('calendar_id')
                ->relationship(name: 'calendar', titleAttribute: 'name')
                    ->label('Calendario')
                    ->required(),
       /*          Forms\Components\Select::make('user_id')
                ->relationship(name: 'user', titleAttribute: 'name')
                    ->required(), */
                Forms\Components\Select::make('type')
                    ->options([
                        'work' => 'Working',
                        'pause' => 'In Pause',
                    ])
                    ->required(),
                Forms\Components\DateTimePicker::make('day_in')
                    ->label('Day in')
                    ->native(false)        // usa el picker de Filament (flatpickr)
                    ->seconds(false)       // horas y minutos (sin segundos)
                    ->displayFormat('d/m/Y H:i') // opcional: formato visible
                    ->required(),
                Forms\Components\DateTimePicker::make('day_out')
                    ->label('Day out')
                    ->native(false)        // usa el picker de Filament (flatpickr)
                    ->seconds(false)       // horas y minutos (sin segundos)
                    ->displayFormat('d/m/Y H:i') // opcional: formato visible
                    ->required(),


            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TimesheetInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        //return TimeSheetsTable::configure($table);
        return $table
            ->columns([
                
                Tables\Columns\TextColumn::make('calendar.name')->label('Calendar')
                    ->toggleable()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')->label('User')
                    ->toggleable()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')->label('Type')
                    ->toggleable()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('day_in')->label('Day In')
                    ->toggleable()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('day_out')->label('Day Out')
                    ->toggleable()
                    ->searchable()
                    ->sortable(),

            ])
            ->filters([
                SelectFilter::make('type')
                ->options([
                    'work' => 'Working',
                    'pause' => 'In Pause',
                ]),
                /*
                Filter::make('calendar_id')
                ->label(__('filters.calendar'))
                */



            ])
            ->recordActions([
            Action::make('edit')
                ->label('Edit')
                ->icon('heroicon-m-pencil-square')
                ->url(fn ($record) => static::getUrl('edit', ['record' => $record])),

           Action::make('delete')
                ->label('Delete')
                ->icon('heroicon-m-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->action(fn ($record) => $record->delete())
            ])
            ->toolbarActions([
                    //Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                    BulkActionGroup::make([
                        DeleteBulkAction::make(),
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
            'index' => ListTimeSheets::route('/'),
            'create' => CreateTimeSheet::route('/create'),
            'view' => ViewTimeSheet::route('/{record}'),
            'edit' => EditTimeSheet::route('/{record}/edit'),
        ];
    }
}
