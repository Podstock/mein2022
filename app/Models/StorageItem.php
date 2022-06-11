<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorageItem extends Model
{
    use HasFactory;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->count = 1;
        $this->storageitemcategory_id = 6;
    }

    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }

    public function storageitemcategory()
    {
        return $this->belongsTo(StorageItemCategory::class);
    }
}
