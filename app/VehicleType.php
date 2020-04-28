<?php

namespace App;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    protected $table = 'vehicle_type';
    protected $fillable = ['name'];
    //protected $hidden = ['_token'];


    public function vechicleType()
    {
        return $this->hasMany('App\Vehicle');
    }

}
