<?php

namespace App\Models\Covenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CovenantItem extends Model
{
    protected $table = 'covenant_items';
    use HasFactory;

    public $timestamps = false; 

    protected $fillable =  [
        'covenant_name',
        'add_by',
        'add_date',
        'serial_number',
        'current_driver',
        'state',
        'delivery_date'
    ];

}
