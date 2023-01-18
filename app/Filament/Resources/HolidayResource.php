<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HolidayResource\Pages;
use App\Filament\Resources\HolidayResource\RelationManagers;
use App\Models\Holiday;
use App\Settings\AttendanceSettings;
use Carbon\Carbon;
use Closure;
use DateTimeZone;
use Filament\Forms;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use HolidaySettings;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
class HolidayResource extends Resource
{
    protected static ?string $model = Holiday::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static function getNavigationGroup(): ?string
    {
        return strval(__('cranberry-punch::cranberry-punch.section.group-attendance-management'));
    }

    public static function form(Form $form): Form
    {
        $value = [];
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date')
                    ->reactive()
                    ->afterStateUpdated(function (Closure $set, $state) {
                        $day = Carbon::parse($state)->format('l');
                        $set('day_name', $day);
                    })
                    ->timezone((config('user_timezone')))
                    ->required(),
                Select::make('day_name')
                    ->options([
                        'Sunday' => 'Sunday', 'Monday' => 'Monday',
                        'Tuesday' => 'Tuesday', 'Wednesday' => 'Wednesday',
                        'Thursday' => 'Thursday', 'Friday' => 'Friday',
                        'Saturday' => 'Saturday'
                    ])
                    ->disabled(function (Closure $get) {
                        return $get('date') !== null;
                    }),
                Forms\Components\TextInput::make('holiday_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('holiday_type')
                    ->options(function () {
                        $dump = [];
                        $json = app(AttendanceSettings::class)->holidays_type;
                        foreach ($json as $item) {
                            $variable = array_values($item['holidays_type']);
                            foreach($json as $item){
                                $variable = $item['holidays_type'];
                                $dump[array_keys($variable)[0]] = array_values($variable)[0];
                            }
                        }
                       return $dump;
                    })
                    ->required(),
                Forms\Components\Toggle::make('is_confirmed')
                    ->label('Holiday Comfirmation Status'),
            ]);
    }
    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date(),
                Tables\Columns\TextColumn::make('day_name'),
                Tables\Columns\TextColumn::make('holiday_name'),
                Tables\Columns\TextColumn::make('holiday_type'),
                Tables\Columns\IconColumn::make('is_confirmed')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListHolidays::route('/'),
            'create' => Pages\CreateHoliday::route('/create'),
            'view' => Pages\ViewHoliday::route('/{record}'),
            'edit' => Pages\EditHoliday::route('/{record}/edit'),
        ];
    }
}
