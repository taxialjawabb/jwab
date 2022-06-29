<?php

namespace App\Models\Rider;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankTransfer extends Model
{
    use HasFactory;
    protected $table = 'bank_transfer';
    use HasFactory;

    public $timestamps = false; 

    protected $fillable =[
        'id',
        'state',
        'bank_name',
        'person_name',
        'amount',
        'transfer_photo',
        'rider_id',
        'admin_id',
        'bond_id',
      
    ];
}
