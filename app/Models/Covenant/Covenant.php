<?php

namespace App\Models\Covenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Covenant extends Model
{
    protected $table = 'covenant';
    use HasFactory;

    public $timestamps = false; 

    protected $fillable =  [
        'covenant_name',
        'add_by',
        'add_date'
    ];
 
}
