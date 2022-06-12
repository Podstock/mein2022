<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $casts = [
        'orga' => 'boolean',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (auth()->user()) {
            $this->user_id = auth()->user()->id;
        }
        $this->duration = 45;
        $this->day = 'day1';
        $this->orga = false;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function help_category()
    {
        return $this->belongsTo(HelpCategory::class);
    }

    public function shiftroles()
    {
        return $this->belongsToMany(Shiftrole::class)->withTimestamps()->withPivot('count');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot('shiftrole_id');
    }
}
