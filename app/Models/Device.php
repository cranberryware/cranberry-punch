<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'user_email',
        'location',
        'serial_number',
        'identifier',
        'status',
        'mode'
    ];


     public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function webhooks()
    {
        return $this->hasMany(Webhook::class);
    }
}
