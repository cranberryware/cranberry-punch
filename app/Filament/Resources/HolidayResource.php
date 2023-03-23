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
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\DatePicker;
class HolidayResource extends Resource
{
    protected static ?string $model = Holiday::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static function getNavigationGroup(): ?string
    {
        return strval(__('cranberry-punch::cranberry-punch.section.group-attendance-management'));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('date')
                    ->label(__('cranberry-punch::cranberry-punch.section.holiday.input.date'))
                    ->timezone(config('app.timezone'))
                    ->afterStateUpdated(function(Closure $set,$state){
                        $day=Carbon::parse($state)->format('l');
                        $set('day_name',$day);
                    })
                    ->reactive()
                    ->required(),
                Select::make('day_name')
                    ->label(__('cranberry-punch::cranberry-punch.section.holiday.input.day_name'))
                    ->options(function() {
                        $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
                        return array_combine($days, $days);
                    })
                    ->disabled(function(Closure $get){
                        return $get('date')!==null;
                    }),
                Forms\Components\TextInput::make('holiday_name')
                    ->label(__('cranberry-punch::cranberry-punch.section.holiday.input.holiday_name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('holiday_type')
                    ->label(__('cranberry-punch::cranberry-punch.section.holiday.input.holiday_type'))
                    ->options(function() {
                        $options = [];
                        foreach (app(AttendanceSettings::class)->holiday_types as $holiday_type) {
                            $options[$holiday_type['slug']] = $holiday_type['name'];
                        }
                        return $options;
                    })
                    ->required(),
                Forms\Components\Toggle::make('is_confirmed')
                    ->label(__('cranberry-punch::cranberry-punch.section.holiday.input.holiday_status'))
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
