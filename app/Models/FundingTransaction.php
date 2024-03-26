<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundingTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'transaction_reference', 'amount', 'payment_method', 'status'];

}
