<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vechile extends Model
{
    use HasFactory;
    protected $table = 'vechile';
    public $timestamps = false; 
    
    protected $dates = [
        'driving_license_expiration_date',
        'insurance_card_expiration_date',
        'periodic_examination_expiration_date',
        'operating_card_expiry_date',
        'add_date',
    ];
    protected $fillable = [
        'vechile_type',
        'made_in',
        'serial_number',
        'plate_number',
        'color',
        'driving_license_expiration_date',
        'insurance_card_expiration_date',
        'periodic_examination_expiration_date',
        'operating_card_expiry_date',
        'add_date',
        'state',
        'admin_id',
        'category_id'
    ];
    public function driver(){
        return $this->hasOne(Driver::class);
    }
}
