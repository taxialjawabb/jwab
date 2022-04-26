<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Driver extends Authenticatable implements JWTSubject {
    use HasFactory;
    protected $table = 'driver';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
     protected $casts = [
        'birth_date' => 'datetime:Y-m-d',
        ];
    protected $dates = [
        'id_expiration_date',
        'license_expiration_date',
        'birth_date',
        'start_working_date',
        'contract_end_date',
        'final_clearance_date',
        'add_date',
        'created_at',
        'updated_at',
    ];
    protected $fillable = [
        'id',
        'name',
        // 'password',
        'available',
        // 'nationality',
        'ssd',
        'address',
        // 'id_copy_no',
        // 'id_expiration_date',
        // 'license_type',
        // 'license_expiration_date',
        // 'birth_date',
        // 'start_working_date',
        // 'contract_end_date',
        // 'final_clearance_date',
        // 'persnol_photo',
        // 'current_vechile',
        // 'add_date',
        // 'admin_id',
        // 'state',
        'email',
        // 'email_verified_at',
        'phone',
        // 'phone_verified_at',
        // 'remember_token',
        // 'created_at',
        // 'updated_at',
        'current_loc_latitude',
        'current_loc_longtitude',
        'current_loc_name',
        'current_loc_zipcode',
        'current_loc_id',
        'account',
        'driver_rate',
        'driver_counter',
        'vechile_rate',
        'vechile_counter',
        'time_rate',
        'time_counter',
    ];
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function driverTrips(){
        return $this->hasMany(Trip::class);
    }
    public function driverBonds(){
        return $this->hasMany(BoxDriver::class);
    }

}
