<?php

namespace App\Models\Rider;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoxRider extends Model
{
    public $timestamps = false; 

    protected $table = 'box_rider';
    use HasFactory;
    protected $fillable =  [
        'rider_id',
        'bond_type',
        'payment_type',
        'money',
        'tax',
        'total_money',
        'descrpition',
        'add_date',
        'add_by',
        'bond_state',
        'confirm_by',
        'confirm_date',
        'trustworthy_by',
        'trustworthy_date',
        'deposited_by',
        'deposit_date',
        'bank_account_number',
    ];
}
