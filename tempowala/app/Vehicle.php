<?php

namespace App;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
  protected $table = 'vehicles';
  
  public function vehicle_type(){
      return $this->belongsTo('App\VehicleType');
  }
}
