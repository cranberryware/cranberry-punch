<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    use RevisionableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * This function returns true if the user can access the filament.
     *
     * @return bool A boolean value.
     */
    public function canAccessFilament(): bool
    {
        return $this->hasRole(['super-admin', 'hr-manager', 'employee']);
    }

    /**
     * The `employee()` function returns a relationship between the `User` model and the `Employee`
     * model
     *
     * @return A single Employee model instance.
     */
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    /**
     * > This function returns the attendances of the user
     *
     * @return The attendances for the user.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

}
