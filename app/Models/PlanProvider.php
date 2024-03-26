<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanProvider extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'active'];

    // Ensure only one row is active at a time
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->active) {
                // Deactivate all other rows
                static::where('id', '!=', $model->id)->update(['active' => false]);
            }
        });
    }
}
