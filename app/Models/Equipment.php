<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class Equipment extends Model
{
    protected $fillable = ['name', 'brand', 'color', 'weight_grams', 'category', 'user_id', 'condition', 'price', 'last_maintained_at'];

    protected $casts = [
        'category' => \App\Enums\EquipmentCategory::class,
        'condition' => \App\Enums\Condition::class,
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('user_owned', function (Builder $builder) {
            if (Auth::check()) {
                $builder->where($builder->getQuery()->from . '.user_id', Auth::id());
            }
        });

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->user_id = Auth::id();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function backpacks()
    {
        return $this->belongsToMany(Backpack::class, 'backpack_equipment');
    }
}
