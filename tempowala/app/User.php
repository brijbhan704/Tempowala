<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    //protected $table = 'administrators';

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password',
        'phone',
        'role_id',
        'status',
        'verified_otp',
        'otp'
    ];

    //protected $with = ['role'];

     protected $appends = ['extra'];

     public function getExtraAttribute()
     {
        return $this->attributes['extra'] = '122';
     }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier() {
      return $this->getKey();
    }
    public function getJWTCustomClaims(){
      return [];
    }

    public function role(){
      return $this->belongsTo('App\Role');
    }

   
    public function generateVarchar(){
      return bin2hex(openssl_random_pseudo_bytes(5));
    }
    public function updateUser($data){
      return DB::table('administrators')->where('id', $data[0]->id)->update(['confirm' => 1]);
    }
}
