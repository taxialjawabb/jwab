<?php

namespace App\Models\Nathiraat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stakeholders extends Model
{
    protected $table = 'stakeholders';
    public $timestamps = false; 

    use HasFactory;
    protected $fillable =  [
        'name',
        'record_number',
        'expire_date',
        'add_date',
        'add_by',
    ];
    public function importsAndExports(){
        return $this->hasMany(App\Models\ImportsAndExport::class);
    }
}
