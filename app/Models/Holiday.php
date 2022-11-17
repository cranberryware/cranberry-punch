<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    protected $fillable=[
        'date',
        'day',
        'holiday_name',
        'holiday_type',
        'is_confirmed'
    ];
}
