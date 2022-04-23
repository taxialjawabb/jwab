<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
class Admin extends Authenticatable implements JWTSubject {
    use LaratrustUserTrait;
    use HasFactory;
    protected $table = 'admins';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'password',
        'nationality',
        'ssd',
        'date_join',
        'Employment_contract_expiration_date',
        'final_clearance_exity_date',
        'working_hours',
        'monthly_salary',
        'roles',
        'state',
        'add_by',
        'email',
        'email_verified_at',
        'phone',
        'phone_verified_at',
        'remember_token',
        'created_at',
        'updated_at        ',
    ];
    protected $hidden = [
        'password',
        'remember_token',
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
}
