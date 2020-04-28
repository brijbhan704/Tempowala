<?php
//amary@321! amary
namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log;
use App\Booking;
use App\Setting;
use App\Vehicle;
use App\VehicleType;
use App\Notification;
use JWTAuth;
use DB;
use PDF;
//use App\UserRating;
use Config;

class BookingController extends Controller
{
   
   /**
   * ge Home pate method
   * @return success or error
   * 
   * */
  public function booking(Request $request){
    
    try{
      $status = 0;
      $message = "";
      
      $validator = Validator::make($request->all(), [
        'username' => 'required|string',
        'useremail' => 'required|string', 
        'distance' => 'required|string',
        'price' => 'required|numeric',
        'mobile' => 'required|string',
        'vehicle_id' => 'required|numeric',
        'origin' => 'required|string',
        'destination' => 'required|string',
        'origin_latlng' => 'required|string',
        'destination_latlng' => 'required|string'
      ]);
      
      
      //$validator->errors()
      if($validator->fails()){
        return response()->json(["status"=>$status,"message"=>"Please provide all mandatory fields","data"=>json_decode("{}")]);
      }
      
      $user  = JWTAuth::user();  
      
      $bookingID = 'TMPWL'.strtoupper(uniqid()).rand(10000,99999);
      $booking = new Booking();
      $booking->bookingID = $bookingID;
      $booking->user_id = $user->id;
      $booking->username = $request->username;
      $booking->useremail = $request->useremail;
      $booking->distance = $request->distance;
      //$booking->price = number_format($request->price,2);
      $booking->vehicle_id = $request->vehicle_id;
      $booking->city = (isset($request->city)) ? $request->city : '';
      
      $vechicleData = Vehicle::with("vehicle_type")->where('id',$request->vehicle_id)->first();
      if(!$vechicleData){
          return response()->json(["status"=>0,"msg"=>"Invalid Vehicle id","data"=>[]]);
      }
      
      $booking->mobile = $request->mobile;
      $booking->origin = $request->origin;
      $booking->destination = $request->destination;
      $booking->origin_latlng = $request->origin_latlng;
      $booking->destination_latlng = $request->destination_latlng;
      
      $booking->base_price = $vechicleData->vehicle_type->base_price;
      if($booking->distance <= 1){
          $rate = $vechicleData->vehicle_type->rate_per_km;
          //$base_price = 
      }else if($booking->distance > 2 && $booking->distance <= 5){
          $rate = $vechicleData->vehicle_type->rate_2_to_5_km;
      }else {
          $rate = $vechicleData->vehicle_type->rate_gt_6_km;
      }
      $booking->rate_per_km = $rate;
      $setting = Setting::where('id',1)->first();
      $booking->price = number_format(($booking->base_price + $booking->distance*$booking->rate_per_km),2);
      $booking->gst = $setting->GST;
      $realGST = $booking->gst/100;
      $booking->price_with_gst = number_format(($booking->price + $booking->price*$realGST),2);
      if(isset($request->coupon_code)){
          $couponData = $this->getCoupon($booking->price_with_gst,$request->coupon_code);
          $booking->coupon_code = $request->coupon_code;
          $booking->coupon_discount = $couponData['coupon_discount'];
          
          if($booking->price_with_gst == $couponData['price']){
             return response()->json(["status"=>0,"msg"=>$couponData['coupon_msg'],"data"=>[]]); 
          }
          $booking->price_with_gst = $couponData['price'];
      }
      
      if(isset($request->pan_card)){
          $booking->pan_card = $request->pan_card;
      }
      
      if(isset($request->pan_card)){
          $booking->pan_card = $request->pan_card;
      }
      
      if(isset($request->gst_number)){
          $booking->gst_number = $request->gst_number;
      }
      
      if($booking->save()){
        $booking->vehicle_name = $vechicleData->name;
        $booking->vehicle_number = $vechicleData->vehicle_number;
        $booking->vehicle_type = $vechicleData->vehicle_type->name;
        
          $msg = "Thanks for Submit Query With Tempowala.Our consult department connect with you shortly.Your Query Submit ID is $bookingID";
          //$msg = "Thanks for booking tempowala.Your booking confirmed and Your booking ID is $bookingID";
          $this->sendsms($request->mobile,$msg);
          return response()->json(["status"=>1,"msg"=>"","data"=>$booking]);                    
      }else{
         
          return response()->json(['status'=>$status,'message'=>'NO Data Found','data'=>json_decode("{}")]);                    
      }   
    }catch(Exception $e){
      return response()->json(['status'=>$status,'message'=>'Exception Error','data'=>json_decode("{}")]);                    
    }
            
  }
  
  /**
   * ge Home pate method
   * @return success or error
   * 
   * */
  public function myBooking(Request $request){
    
    try{
      $status = 0;
      $message = "";
      
      $user  = JWTAuth::user();  
      
      $bookingData = Booking::with('notification')->select('bookings.*',
      'vehicles.name','vehicle_type.name as vehicle_type_name'
      )
      ->join('users', 'users.id', '=', 'bookings.user_id')
      ->join('vehicles', 'vehicles.id', '=', 'bookings.vehicle_id')
      ->join('vehicle_type', 'vehicle_type.id', '=', 'vehicles.vehicle_type_id')
      ->where('user_id',$user->id)->orderBy('bookings.id','DESC')->get();
      if(!$bookingData->count()){
          return response()->json(["status"=>0,"msg"=>"Invalid Vehicle id","data"=>[]]);
      }
      
      return response()->json(["status"=>1,"msg"=>"","data"=>$bookingData]);
      
    }catch(Exception $e){
      return response()->json(['status'=>$status,'message'=>'Exception Error','data'=>json_decode("{}")]);                    
    }
            
  }
  
  /**
   * ge Home pate method
   * @return success or error
   * 
   * */
  public function getBookingById(Request $request){
    
    try{
      $status = 0;
      $message = "";
      $validator = Validator::make($request->all(), [
        'booking_id' => 'required|string'
      ]);
      
      
      //$validator->errors()
      if($validator->fails()){
        return response()->json(["status"=>$status,"message"=>"Please provide booking id","data"=>json_decode("{}")]);
      }
      $user  = JWTAuth::user();  
      //echo $user->id; die;
      $bookingData = Booking::select('bookings.*','vehicle_type.rate_per_km',
      'vehicle_type.rate_2_to_5_km','vehicle_type.rate_gt_6_km',
      'vehicle_type.capacity','vehicle_type.name as vehicle_type_name',
      'vehicles.name as vehicle_name')
      ->join('vehicles', 'vehicles.id', '=', 'bookings.vehicle_id')
      ->join('vehicle_type', 'vehicle_type.id', '=', 'vehicles.id')
      ->where([
          ['bookingID',$request->booking_id],
          ['user_id',$user->id]
          ])->get();
      if(!$bookingData->count()){
          return response()->json(["status"=>0,"msg"=>"No record found","data"=>[]]);
      }
      $setting = Setting::where('id',1)->first();
      foreach($bookingData as $k=>$v){
          if($v->distance <=1){
              $v->base_price = $v->rate_per_km;
          }
          if($v->distance > 1 && $v->distance < 6){
              $v->base_price = $v->rate_2_to_5_km;
          }
          
          if($v->distance > 6){
              $v->base_price = $v->rate_gt_6_km;
          }
          
          $v->pdf_link = "";
          $gst = $setting->GST/100;
          $v->name = $v->vehicle_type_name;
          $v->total_price = number_format($v->price + ($v->price*$gst),2);
          $v->GST = $setting->GST . '%';        
      }
      return response()->json(["status"=>1,"msg"=>"","data"=>$bookingData]);
      
    }catch(Exception $e){
      return response()->json(['status'=>$status,'message'=>'Exception Error','data'=>json_decode("{}")]);                    
    }
            
  }
  
  /**
   * ge Home pate method
   * @return success or error
   * 
   * */
  public function getNotificationById(Request $request){
    
    try{
      $status = 0;
      $message = "";
      
      $user  = JWTAuth::user();  
      //echo $user->id; die;
      $bookingData = Booking::with(['notification'])->where('user_id',$user->id)->get();
    //   $bookingData = Notification::select('notifications.*',
    //   'bookings.username','bookings.useremail',
    //   'bookings.bookingID as orderID','bookings.distance','bookings.price',
    //   'bookings.mobile','bookings.created_at as order_date')
    //   ->leftJoin('bookings', 'bookings.id', '=', 'notifications.booking_id')
    //   ->where('booking_id',$request->booking_id)->get();
      if(!$bookingData->count()){
          return response()->json(["status"=>0,"msg"=>"No record found","data"=>[]]);
      }
      
      return response()->json(["status"=>1,"msg"=>"","data"=>$bookingData]);
      
    }catch(Exception $e){
      return response()->json(['status'=>$status,'message'=>'Exception Error','data'=>json_decode("{}")]);                    
    }
            
  }
  
  public function getNotificationCount(Request $request){
    
    try{
      $status = 0;
      $message = "";
      //echo 'sfasfds'; die;
      $user  = JWTAuth::user();  
      //echo $user->id; die;
      $bookingData = Booking::join('notifications', 'bookings.id', '=', 'notifications.booking_id')->where([
          ['bookings.user_id',$user->id],
          ['notifications.read_status',0]
          ])->count();
    
      return response()->json(["status"=>1,"msg"=>"","data"=>$bookingData]);
      
    }catch(Exception $e){
      return response()->json(['status'=>$status,'message'=>'Exception Error','data'=>json_decode("{}")]);                    
    }
            
  }
  
  public function readNotification(Request $request){
    
    try{
      $status = 0;
      $message = "";
      //echo 'sfasfds'; die;
      $user  = JWTAuth::user();  
      //echo $request->id; die;
      $ids = Booking::select(DB::raw('group_concat(id) as ids'))
      ->where('user_id',$user->id)
      ->get();
      $ids[0]->ids; 
      if(!empty($ids[0]->ids)){
          $notification = Notification::whereIn('booking_id',explode(",",$ids[0]->ids))
          ->update(['read_status'=>1]);
          return response()->json(["status"=>1,"msg"=>"","data"=>[]]);
      }else{
          return response()->json(["status"=>0,"msg"=>"Not updated","data"=>[]]);
      }
      //echo $user->id; die;
      
      
    }catch(Exception $e){
      return response()->json(['status'=>$status,'message'=>'Exception Error','data'=>json_decode("{}")]);                    
    }
            
  }
  
    public function pdfview(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'booking_id' => 'required|string'
        ]);
          
          
          //$validator->errors()
        if($validator->fails()){
            return response()->json(["status"=>$status,"message"=>"Please provide booking id","data"=>json_decode("{}")]);
        }
      
        $bookings = DB::table("bookings")->where('bookingID',$request->booking_id)->first();
        view()->share('bookings',$bookings);
    
        if($request->has('download')){
        	// Set extra option
        	PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        	// pass view file
            $pdf = PDF::loadView('pdfview');
            // download pdf
            return $pdf->download('pdfview.pdf');
        }
        return view('pdfview');
    }
  
}
