<?php

namespace App\Models;

use App\Models\Scopes\HolidayScope;
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

    protected static function booted()
    {
        static::addGlobalScope(new HolidayScope);
    }
}
