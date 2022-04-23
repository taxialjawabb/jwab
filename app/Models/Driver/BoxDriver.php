<?php

namespace App\Models\Driver;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoxDriver extends Model
{
    protected $table = 'box_driver';
    public $timestamps = false; 

    use HasFactory;
    protected $fillable =  [
        'driver_id',
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
    public function driver(){
        return $this->belongsTo(Driver::class,  'foreign_key', 'driver_id');
    }
}
