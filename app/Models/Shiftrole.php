<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shiftrole extends Model
{
    use HasFactory;

    public function shifts()
    {
        return $this->belongsToMany(Shift::class)->withTimestamps()->withPivot('count');
    }

    public function full($shift_id)
    {
        $shift = $this->shifts->find($shift_id);
        foreach (auth()->user()->shifts as $myshift) {
            if ($myshift->day == $shift->day && $myshift->time == $shift->time) {
                return true;
            }
        }
        $allowed = $this->shifts->find($shift_id)->pivot->count;
        $found = $this->shifts->find($shift_id)->users()->wherePivot('shiftrole_id', $this->id)->count();

        if ($found >= $allowed) {
            return true;
        }

        return false;
    }
}
