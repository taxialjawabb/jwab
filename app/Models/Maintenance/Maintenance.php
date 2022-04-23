<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $table = 'maintenance';
    use HasFactory;

    public $timestamps = false; 

    protected $fillable =[
        'id',
        'maintenance_type',
        'counter_number',
        'counter_photo',
        'bill_photo',
        'added_date',
        'maintenance_note',
        'vechile_id',
        'driver_id',
        'admin_id',
        'confirm_date',
    ];
}
