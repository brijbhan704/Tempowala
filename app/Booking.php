<?php

namespace App;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    
    public function vehicle(){
      return $this->belongsTo('App\Vehicle');
    }
    public function user(){
      return $this->belongsTo('App\User');
    }
    
    public function notification(){
      return $this->hasMany('App\Notification');
    }
}
