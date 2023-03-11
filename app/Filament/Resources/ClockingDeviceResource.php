<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Enums\DeviceMode;
use App\Enums\DeviceStatus;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Models\ClockingDevice;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Papalardo\FilamentPasswordInput\PasswordInput;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ClockingDeviceResource\Pages;
use App\Filament\Resources\ClockingDeviceResource\RelationManagers;

class ClockingDeviceResource extends Resource
{
    protected static ?string $model = ClockingDevice::class;

    protected static ?string $navigationIcon = 'heroicon-o-finger-print';

    protected static function getNavigationGroup(): ?string
    {
        return strval(__('cranberry-punch::cranberry-punch.section.group-attendance-management'));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('device_name')
                    ->label(__('cranberry-punch::cranberry-punch.device.device_name'))
                    ->required(),
                TextInput::make('device_location')
                    ->label(__('cranberry-punch::cranberry-punch.device.device_location'))
                    ->required(),
                TextInput::make('device_serial')
                    ->label(__('cranberry-punch::cranberry-punch.device.device_serial'))
                    ->required(),
                TextInput::make('device_identifier')
                    ->label(__('cranberry-punch::cranberry-punch.device.device_identifier'))
                    ->required(),
                Select::make('device_status')
                    ->label(__('cranberry-punch::cranberry-punch.device.device_status'))
                    ->options(DeviceStatus::getStatuses())
                    ->required(),
                Select::make('device_mode')
                    ->label(__('cranberry-punch::cranberry-punch.device.device_mode'))
                    ->options(DeviceMode::getModes())
                    ->required(),
                TextInput::make('emp_prefix')
                    ->label(__('cranberry-punch::cranberry-punch.device.emp_prefix')),
                PasswordInput::make('device_secret')
                    ->label(__('cranberry-punch::cranberry-punch.device.device_secret')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('device_name')
                    ->label(__('cranberry-punch::cranberry-punch.device.device_name')),
                TextColumn::make('device_location')
                    ->label(__('cranberry-punch::cranberry-punch.device.device_location')),
                TextColumn::make('device_serial')
                    ->label(__('cranberry-punch::cranberry-punch.device.device_serial')),
                TextColumn::make('device_identifier')
                    ->label(__('cranberry-punch::cranberry-punch.device.device_identifier')),
                TextColumn::make('device_status')
                    ->label(__('cranberry-punch::cranberry-punch.device.device_status'))
                    ->formatStateUsing(function ($state) {
                        return (__("cranberry-punch::cranberry-punch.device.status.{$state}"));
                    }),
                TextColumn::make('device_mode')
                    ->label(__('cranberry-punch::cranberry-punch.device.device_mode'))
                    ->formatStateUsing(function ($state) {
                        return (__("cranberry-punch::cranberry-punch.device.mode.{$state}"));
                    }),
                TextColumn::make('emp_prefix')
                    ->label(__('cranberry-punch::cranberry-punch.device.emp_prefix'))
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
            'index' => Pages\ListClockingDevices::route('/'),
            'create' => Pages\CreateClockingDevice::route('/create'),
            'view' => Pages\ViewClockingDevices::route('/{record}'),
            'edit' => Pages\EditClockingDevice::route('/{record}/edit'),
        ];
    }
}
