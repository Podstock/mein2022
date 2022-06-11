<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    use HasFactory;


    public function depot()
    {
        return $this->belongsTo(Depot::class);
    }

    public function storageitems()
    {
        return $this->hasMany(StorageItem::class);
    }
}
