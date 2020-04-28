<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log;
use App\Vehicle;
use App\Setting;
use Config;
use JWTAuth;

class CouponController extends Controller
{
    
    
    public function checkCoupon(Request $request){
    
    try{
      $status = 0;
      $message = "";
      
      $validator = Validator::make($request->all(), [
        'price' => 'required|string',
        'code' => 'required|string'
      ]);
      
      //$validator->errors()
      if($validator->fails()){
        return response()->json(["status"=>$status,"message"=>"Please provide all mandatory fields","data"=>json_decode("{}")]);
      }
      
      $user  = JWTAuth::user();
      
      $couponData = $this->getCoupon($request->price,$request->code);
      
      return response()->json(['status'=>1,'message'=>'','data'=>$couponData]);
       
    }catch(Exception $e){
      return response()->json(['status'=>$status,'message'=>'Exception Error','data'=>json_decode("{}")]);                    
    }
            
  }  
}
