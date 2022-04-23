<?php

namespace App\Models\Vechile;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoxVechile extends Model
{
    public $timestamps = false; 

    protected $table = 'box_vechile';
    use HasFactory;
    protected $fillable =  [
        'vechile_id',
        'foreign_type',
        'foreign_id',
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
