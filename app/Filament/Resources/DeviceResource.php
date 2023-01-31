<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeviceResource\Pages;
use App\Filament\Resources\DeviceResource\RelationManagers;
use App\Models\Device;
use Filament\Forms;
use Filament\Forms\Components\Section;
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

class DeviceResource extends Resource
{
    protected static ?string $model = Device::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('cranberry-punch::cranberry-punch.section.devices'))
                ->schema([
                      
                       TextInput::make('name')
                        ->label(__('cranberry-punch::cranberry-punch.device.input.name'))
                        ->placeholder(__('cranberry-punch::cranberry-punch.device.input.name'))
                        ->required(),
                        TextInput::make('location')
                        ->label(__('cranberry-punch::cranberry-punch.device.input.location'))
                        ->placeholder(__('cranberry-punch::cranberry-punch.device.input.location'))
                        ->required(),
                        TextInput::make('serial_number')
                        ->label(__('cranberry-punch::cranberry-punch.device.input.serial_number'))
                        ->placeholder(__('cranberry-punch::cranberry-punch.device.input.serial_number'))
                        ->required(),
                        TextInput::make('identifier')
                        ->label(__('cranberry-punch::cranberry-punch.device.input.identifier'))
                        ->placeholder(__('cranberry-punch::cranberry-punch.device.input.identifier'))
                        ->required(),
                        Select::make('status')
                        ->label(__('cranberry-punch::cranberry-punch.device.input.status'))
                        ->options([
                            'active' => 'Active',
                            'inactive' => 'InActive'
                        ]),
                        Select::make('mode')
                        ->label(__('cranberry-punch::cranberry-punch.device.input.mode'))
                        ->options([
                            'check-in' => 'CheckIn',
                            'check-out' => 'CheckOut',
                            'both' => 'Both'
                        ])
               
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->label(__('cranberry-punch::cranberry-punch.table.name')),
                TextColumn::make('location')
                ->label(__('cranberry-punch::cranberry-punch.table.location')),
                TextColumn::make('serial_number')
                ->label(__('cranberry-punch::cranberry-punch.table.serial_number'))
                ->sortable(),
                TextColumn::make('identifier')
                ->label(__('cranberry-punch::cranberry-punch.table.identifier'))
                ->sortable(),
                TextColumn::make('status')
                ->label(__('cranberry-punch::cranberry-punch.table.status'))
                ->sortable(),
                TextColumn::make('mode')
                ->label(__('cranberry-punch::cranberry-punch.table.mode'))
                ->sortable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListDevices::route('/'),
            'create' => Pages\CreateDevice::route('/create'),
            'edit' => Pages\EditDevice::route('/{record}/edit'),
        ];
    }    
}
