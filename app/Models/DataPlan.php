<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'network_name',
        'plan_id',
        'amount',
        'buying_price',
        'selling_price',
        'validity',
        'plan_type',
        'order_number',
        'provider_id',
        'active',
    ];


    public function planProvider()
    {
        return $this->belongsTo(PlanProvider::class, 'provider_id');
    }
}
