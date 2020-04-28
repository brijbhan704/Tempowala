<?php

namespace App;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    
    
    public function booking(){
      return $this->belongsTo('App\Booking');
    }
}
