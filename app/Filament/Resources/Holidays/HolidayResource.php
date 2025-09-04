<?php

namespace App\Filament\Resources\Holidays;

use App\Filament\Resources\Holidays\Pages\CreateHoliday;
use App\Filament\Resources\Holidays\Pages\EditHoliday;
use App\Filament\Resources\Holidays\Pages\ListHolidays;
use App\Filament\Resources\Holidays\Pages\ViewHoliday;
use App\Filament\Resources\Holidays\Schemas\HolidayForm;
use App\Filament\Resources\Holidays\Schemas\HolidayInfolist;
use App\Filament\Resources\Holidays\Tables\HolidaysTable;
use App\Models\Holiday;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\Action;

class HolidayResource extends Resource
{
    protected static ?string $model = Holiday::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string|\UnitEnum|null $navigationGroup = 'Employee Management';

    protected static ?int $navigationSort = 3;    

    protected static ?string $recordTitleAttribute = 'day';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('calendar_id')
                ->relationship(name: 'calendar', titleAttribute: 'name')
                    ->label('Calendario')
                    ->required(),
                Select::make('user_id')
                ->relationship(name: 'user', titleAttribute: 'name')
                    ->required(),
                Select::make('type')
                    ->options([
                        'decline' => 'Decline',
                        'approved' => 'Approved',
                        'pending' => 'Pending',
                    ])
                    ->required(),
                DatePicker::make('day')
                    ->required(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return HolidayInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
            return $table
            ->columns([
                Tables\Columns\TextColumn::make('calendar.name')
                    ->label('Calendar')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('day')
                    ->date()
                    ->sortable()
                    ->searchable(),                    
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'approved' => 'success',
                        'decline' => 'danger',
                        })                     
                     ->sortable()
                    ->searchable(),

            ])
            ->filters([
                SelectFilter::make('type')
                ->options([
                    'decline' => 'Decline',
                    'approved' => 'Approved',
                    'pending' => 'Pending',
                ]),
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
            ])            
            
            ;
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
            'index' => ListHolidays::route('/'),
            'create' => CreateHoliday::route('/create'),
            'view' => ViewHoliday::route('/{record}'),
            'edit' => EditHoliday::route('/{record}/edit'),
        ];
    }
}
