<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role;

class CustomRole extends Role
{
    use HasFactory;


    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(CustomPermission::class);
    }
    
}
