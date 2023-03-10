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
                TextInput::make('device_secret')
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
                    ->label(__('cranberry-punch::cranberry-punch.device.emp_prefix')),
                TextColumn::make('device_secret')
                    ->label(__('cranberry-punch::cranberry-punch.device.device_secret')),
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
            'index' => Pages\ListClockInDevices::route('/'),
            'create' => Pages\CreateClockInDevice::route('/create'),
            'view' => Pages\ViewClockInDevices::route('/{record}'),
            'edit' => Pages\EditClockInDevice::route('/{record}/edit'),
        ];
    }
}
