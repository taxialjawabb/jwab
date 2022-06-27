<?php

namespace App\Models\MaintenanceCenter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDelivered extends Model
{
    protected $table = 'products_deliverd';
    use HasFactory;

    public $timestamps = false; 

    protected $fillable =  [
        'product_id',
        'count',
        'driver_id',
        'vechile_id',
        'price',
        'add_date',
        'add_by',
    ];
}
