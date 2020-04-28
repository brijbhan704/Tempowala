<?php
//amary@321! amary
namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log;
use App\Vehicle;
use App\Setting;
//use App\UserRating;
use Config;

class VehicleController extends Controller
{
   
   /**
   * ge Home pate method
   * @return success or error
   * 
   * */
  public function vechileBook(Request $request){
    
    try{
      $status = 0;
      $message = "";
      
      $validator = Validator::make($request->all(), [
        'pickup' => 'required|string',
        'drop' => 'required|string' 
      ]);
      
      //$validator->errors()
      if($validator->fails()){
        return response()->json(["status"=>$status,"message"=>"Please provide pickpu and drop","data"=>json_decode("{}")]);
      }
      list($lat1,$lng1) = explode(",",$request->pickup);    
      list($lat2,$lng2) = explode(",",$request->drop);    
      
      //$distance = $this->distance($lat1,$lng1,$lat2,$lng2);
      $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=$lat1,$lng1&destinations=$lat2,$lng2&key=AIzaSyC3AzqK1aDmjfPOO_RFJAf5Vrkosh25wO8";
      
      $distance = file_get_contents($url);
      $distance = json_decode($distance);
      
      list($kmVal,$unit) = explode(" ",$distance->rows[0]->elements[0]->distance->text);
      $result = Vehicle::with(['vehicle_type'])->get();
      if($result->count() > 0){
          foreach($result as $k=>$v){
              //$v->rate_par_km*$kmVal; die;
              $rate = 1;
              if($kmVal <= 1){
                  $rate = $v->vehicle_type->rate_per_km;
                  //$base_price = 
              }else if($kmVal > 2 && $kmVal <= 5){
                  $rate = $v->vehicle_type->rate_2_to_5_km;
              }else {
                  $rate = $v->vehicle_type->rate_gt_6_km;
              }
              
              if($unit != "km"){
                $kmVal = ($kmVal/1000);  
                $v->total_price = $rate*$kmVal;  
              }else{
                $v->total_price = $rate*$kmVal;  
              }
              $v->total_price = $v->total_price + $v->vehicle_type->base_price;
              
              $setting = Setting::where('id',1)->first();
              $gst = $setting->GST/100;
              $v->total_price_gst = $v->total_price + ($v->total_price*$gst);
              $v->total_price = $v->total_price.' Rs';
              $v->total_price_gst = $v->total_price_gst.' Rs';
              
              $result[$k]->type = $v->vehicle_type->name;
              $result[$k]->image = $v->vehicle_type->image;
              $result[$k]->distance = $kmVal.' '.$unit;
              $result[$k]->base_price = $v->vehicle_type->base_price;
              //$result[$k]->base_price = $rate;
              unset($v->vehicle_type);
          }
      }
      $response = ["status"=>1,"msg"=>"","data"=>["vehicle"=>$result,"distance"=>$distance]];
      if($result->count() > 0){
          return response()->json($response);                    
      }else{
         
          return response()->json(['status'=>$status,'message'=>'NO Data Found','data'=>json_decode("{}")]);                    
      }   
    }catch(Exception $e){
      return response()->json(['status'=>$status,'message'=>'Exception Error','data'=>json_decode("{}")]);                    
    }
            
  }
  
  public function vechileList(Request $request){
    
    try{
      $status = 0;
      $message = "";
      
      $result = Vehicle::with(['vehicle_type'])->get();
      if($result->count() > 0){
          foreach($result as $k=>$v){
              $result[$k]->type = $v->vehicle_type->name;
              $result[$k]->rate_per_km = $v->vehicle_type->rate_per_km;
              $result[$k]->rate_2_to_5_km = $v->vehicle_type->rate_2_to_5_km;
              $result[$k]->rate_gt_6_km = $v->vehicle_type->rate_gt_6_km;
              $result[$k]->capacity = $v->vehicle_type->capacity;
              $result[$k]->base_price = $v->vehicle_type->base_price;
              $result[$k]->image = $v->vehicle_type->image;
              //$result[$k]->rate_gt_6_km = $v->vehicle_type->rate_gt_6_km;
              unset($v->vehicle_type);
          }
      }
      $response = ["status"=>1,"msg"=>"","data"=>$result];
      if($result->count() > 0){
          return response()->json($response);                    
      }else{
         
          return response()->json(['status'=>$status,'message'=>'NO Data Found','data'=>json_decode("{}")]);                    
      }   
    }catch(Exception $e){
      return response()->json(['status'=>$status,'message'=>'Exception Error','data'=>json_decode("{}")]);                    
    }
            
  }
}
