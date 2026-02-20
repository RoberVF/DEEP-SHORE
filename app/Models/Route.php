<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = ['name', 'backpack_id', 'duration_days', 'location', 'date'];

    public function backpack()
    {
        return $this->belongsTo(Backpack::class);
    }

    public function equipment()
    {
        return $this->hasManyThrough(
            \App\Models\Equipment::class,
            \App\Models\Backpack::class,
            'id',
            'id',
            'backpack_id',
            'id'
        )->join('backpack_equipment', 'equipment.id', '=', 'backpack_equipment.equipment_id')
            ->whereColumn('backpack_equipment.backpack_id', 'backpacks.id');
    }
}
