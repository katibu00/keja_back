<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'transaction_reference',
        'purchase_type',
        'data_plan_id',
        'payment_method',
        'status',
        'notes',
    ];


    public function data_plan()
    {
        return $this->belongsTo(DataPlan::class, 'data_plan_id','plan_id');
    }
}
