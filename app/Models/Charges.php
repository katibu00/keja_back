<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charges extends Model
{
    use HasFactory;

    protected $fillable = [
        'welcome_bonus',
        'referral_bonus',
        'whatsapp_number',
        'funding_charges_description',
        'funding_charges_amount',
        'charges_per_chat',
        'bonus_per_gb',
    ];
}
