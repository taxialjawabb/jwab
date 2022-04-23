<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    use HasFactory;

    public $timestamps = false; 

    protected $fillable =  [
        'category_name',
        'basic_price',
        'km_cost',
        'reject_cost',
        'cancel_cost',
        'daily_revenue_cost',
        'percentage_type',
        'fixed_percentage',
        'category_percent',
        'admin_id',
    ];
    public function cities(){
        return $this->hasMany(City::class);
    }

    public function secondary(){
        return $this->hasMany(SecondaryCategory::class);
    }
}
