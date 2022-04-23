<?php

namespace App\Models\Covenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CovenantNotes extends Model
{
    
    protected $table = 'notes_covenant';
    use HasFactory;

    public $timestamps = false; 

    protected $fillable =  [
        'record_id',
        'subject',
        'description',
        'add_date',
        'add_by',
        'image',
    ];

}
