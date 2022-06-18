<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function logo_path($format = '')
    {
        $prefix = '/storage/';
        if ($format) {
            $prefix = "/storage/$format/";
        }
        if ($this->logo) {
            return $prefix.$this->logo;
        }

        return '/avatar.png';
    }

    public function myurl()
    {
        if (!preg_match("/^http(s){0,1}\:\/\//", $this->url)) {
            return 'https://'.$this->url;
        }

        return $this->url;
    }

}
