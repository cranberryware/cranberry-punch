<?php

namespace App\Filament\Resources;

use App\Enums\DeviceMode;
use App\Enums\DeviceStatus;
use App\Filament\Resources\ClockInDeviceResource\Pages;
use App\Filament\Resources\ClockInDeviceResource\RelationManagers;
use App\Models\ClockInDevice;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClockInDeviceResource extends Resource
{
    protected static ?string $model = ClockInDevice::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static function getNavigationGroup(): ?string
    {
        return strval(__('cranberry-punch::cranberry-punch.section.group-attendance-management'));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('device_name')
                    ->required(),
                TextInput::make('device_location')
                    ->required(),
                TextInput::make('device_serial')
                    ->required(),
                TextInput::make('device_identifier')
                    ->required(),
                Select::make('device_status')
                    ->options(DeviceStatus::getStatuses())
                    ->required(),
                Select::make('device_mode')
                    ->options(DeviceMode::getModes())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('device_name'),
                TextColumn::make('device_location'),
                TextColumn::make('device_serial'),
                TextColumn::make('device_identifier'),
                TextColumn::make('device_status')
                    ->formatStateUsing(function ($state) {
                        return (__("cranberry-punch::cranberry-punch.device.status.{$state}"));
                    }),
                TextColumn::make('device_mode')
                    ->formatStateUsing(function ($state) {
                        return (__("cranberry-punch::cranberry-punch.device.mode.{$state}"));
                    }),
            ])
            ->filters([
                SelectFilter::make('device_status')
                    ->multiple()
                    ->options(DeviceStatus::getStatuses()),
                SelectFilter::make('device_mode')
                    ->multiple()
                    ->options(DeviceMode::getModes())
            ])
            ->actions([
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
            'index' => Pages\ListClockInDevices::route('/'),
            'create' => Pages\CreateClockInDevice::route('/create'),
            'edit' => Pages\EditClockInDevice::route('/{record}/edit'),
        ];
    }
}
