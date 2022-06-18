<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrivingService extends Model
{
    use HasFactory;
    protected $fillable = [
        'day', 'time',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function driver()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
