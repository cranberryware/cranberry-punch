<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PermissionResource\Pages\ListPermission;
use App\Filament\Resources\PermissionResource\Pages\CreatePermission;
use App\Filament\Resources\PermissionResource\Pages\EditPermission;
use App\Filament\Resources\PermissionResource\Pages\ViewPermission;
use Phpsa\FilamentAuthentication\Resources\PermissionResource as FilamentPermissionResources;


class PermissionResource extends FilamentPermissionResources
{
    public static function getPages(): array
    {
        return [
            'index' => ListPermission::route('/'),
            'create' => CreatePermission::route('/create'),
            'edit' => EditPermission::route('/{record}/edit'),
            'view' => ViewPermission::route('/{record}'),
        ];
    }
}
