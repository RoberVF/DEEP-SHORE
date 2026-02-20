<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $fillable = ['name', 'brand', 'color', 'weight_grams', 'category'];

    protected $casts = [
        'category' => \App\Enums\EquipmentCategory::class,
        'condition' => \App\Enums\Condition::class,
    ];
    public function backpacks()
    {
        return $this->belongsToMany(Backpack::class, 'backpack_equipment');
    }
}
