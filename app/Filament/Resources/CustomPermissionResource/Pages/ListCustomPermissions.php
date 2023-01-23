<?php

namespace App\Filament\Resources\CustomPermissionResource\Pages;

use App\Filament\Resources\CustomPermissionResource;
use Filament\Forms\Components\Select;
use Filament\Notifications\Collection;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\BulkAction;
use Phpsa\FilamentAuthentication\Resources\PermissionResource\Pages\ListPermissions;
use Phpsa\FilamentAuthentication\Resources\RoleResource\Pages\ListRoles;

class ListCustomPermissions extends ListRecords
{
    protected static string $resource = CustomPermissionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    
    
}
