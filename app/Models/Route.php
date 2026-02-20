<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class Route extends Model
{
    protected $fillable = ['name', 'backpack_id', 'duration_days', 'location', 'date', 'user_id'];


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
    public function backpack()
    {
        return $this->belongsTo(Backpack::class);
    }

    public function equipment()
    {
        return $this->belongsToMany(
            Equipment::class,
            'backpack_equipment',
            'backpack_id',
            'equipment_id',
            'backpack_id',
            'id'
        );
    }
}
