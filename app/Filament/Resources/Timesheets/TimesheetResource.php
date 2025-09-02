<?php

namespace App\Filament\Resources\Timesheets;

use App\Filament\Resources\Timesheets\Pages\CreateTimesheet;
use App\Filament\Resources\Timesheets\Pages\EditTimesheet;
use App\Filament\Resources\Timesheets\Pages\ListTimesheets;
use App\Filament\Resources\Timesheets\Pages\ViewTimesheet;
use App\Filament\Resources\Timesheets\Schemas\TimesheetForm;
use App\Filament\Resources\Timesheets\Schemas\TimesheetInfolist;
use App\Filament\Resources\Timesheets\Tables\TimesheetsTable;
use App\Models\Timesheet;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
//use Filament\Tables\Actions\Action;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Filters\Filter;


class TimesheetResource extends Resource
{
    protected static ?string $model = Timesheet::class;

    //protected static ?string $navigationLabel = 'Employees';

    protected static string|\UnitEnum|null $navigationGroup = 'Employee Management';

    protected static ?int $navigationSort = 2;


    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTableCells;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        //return TimesheetForm::configure($schema);
        return $schema
            ->schema([
                Forms\Components\Select::make('calendar_id')
                ->relationship(name: 'calendar', titleAttribute: 'name')
                    ->label('Calendario')
                    ->required(),
                Forms\Components\Select::make('user_id')
                ->relationship(name: 'user', titleAttribute: 'name')
                    ->required(),
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
        //return TimesheetsTable::configure($table);
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
                ->action(fn ($record) => $record->delete()),
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
            'index' => ListTimesheets::route('/'),
            'create' => CreateTimesheet::route('/create'),
            'view' => ViewTimesheet::route('/{record}'),
            'edit' => EditTimesheet::route('/{record}/edit'),
        ];
    }
}
