<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Backpack extends Model
{
    protected $fillable = ['name', 'description'];

    public function equipment()
    {
        return $this->belongsToMany(Equipment::class, 'backpack_equipment');
    }
}
