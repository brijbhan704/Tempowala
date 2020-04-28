<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Classes\UploadFile;
use App\Booking;
use App\Notification;
use App\Message;
use App\VehicleType;

class BookingController extends Controller
{
    /*
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   private $_vehicleTableName = 'Booking';   
   private $_vehicleView = 'bookings';
   public function index()
   {
                        
       try{
         //$cat = Booking::where('id','<>',0)->get();

         $obj = Booking::with(['user','vehicle'])->paginate(config('app.paging'));
         //echo '<pre>'; print_r($uesrs); die;
         return view($this->_vehicleView.'.index', [$this->_vehicleView => $obj]);
       }catch(Exception $e){
         abort(500, $e->message());
       }
   }

   

   public function bookingIndexAjax(Request $request){
    
     $draw = ($request->data["draw"]) ? ($request->data["draw"]) : "1";
     $response = [
       "recordsTotal" => "",
       "recordsFiltered" => "",
       "data" => "",
       "success" => 0,
       "msg" => ""
     ];
     try {
         
         $start = ($request->start) ? $request->start : 0;
         $end = ($request->length) ? $request->length : 10;
         $search = ($request->search['value']) ? $request->search['value'] : '';
         //echo 'ddd';die;
         $cond[] = [];
         
         //echo '<pre>'; print_r($users); die; categoryFilter
         $obj = Booking::with(['user','vehicle'])->whereRaw('1 = 1');

         
         if ($request->search['value'] != "") {            
           $obj = $obj->where('username','LIKE',"%".$search."%");
           $obj = $obj->orWhere('bookingID','LIKE',"%".$search."%");
           $obj = $obj->orWhere('email','LIKE',"%".$search."%");
           $obj = $obj->orWhere('mobile','LIKE',"%".$search."%");
         } 

         $total = $obj->count();
         if($end==-1){
           $obj = $obj->get();
         }else{
           $obj = $obj->skip($start)->take($end)->get();
         }
         
         $response["recordsFiltered"] = $total;
         $response["recordsTotal"] = $total;
         //response["draw"] = draw;
         $response["success"] = 1;
         $response["data"] = $obj;
         
       } catch (Exception $e) {    

       }
     

     return response($response);
   }

  /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function add(Request $request)
   {
     $response = ['success'=>0,"message"=>"","data"=>[]];
     try{
       Log::info('create new user profile for user:');
       $type = VehicleType::where('id','<>',0)->get();
       if($request->isMethod('post')){

        $validator = Validator::make($request->all(), [
          'name' => 'required|string'
        ]);
        
        //$validator->errors()
        if($validator->fails()){
          $request->session()->flash('message.level', 'error');
          $request->session()->flash('message.content', $validator->errors());
          return redirect('vehicles');
          
        }
        //print_r($_FILES); die;
        
        $obj = new Vehicle();       
        $obj->name = $request->input('name');
        $obj->vehicle_number = $request->input('vehicle_number');
        $obj->vehicle_type_id = $request->input('vehicle_type_id');
        $obj->rate_per_km = $request->input('rate_per_km');
               
        
        if($obj->save()){
          $request->session()->flash('message.level', 'success');
          $request->session()->flash('message.content', '"'.$request->input('name').'" added successfully');
          return redirect('vehicles');
        }else{
          $request->session()->flash('message.level', 'error');
          $request->session()->flash('message.content', '"'.$request->input('name').'" not added');
          return redirect('vechicles');
        }
       }else{
        return view('vehicles.add', compact('type')); 
       }
              
     }catch(Exception $e){
       Log::info('type add exception:='.$e->message());
       $response['message'] = 'Opps! Somthing went wrong';
       echo json_encode($response);
       abort(500, $e->message());
     }
   }

   /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      try{
        //$type = Booking::where('id','<>',0)->get();  
        $booking = Booking::with(['user','vehicle'])->where('id',$id)->first();
        $message = Message::all();
        //echo '<pre>'; print_r($booking);
        if(!$booking->count()){
            return redirect('bookings');
        }
        
        return view('bookings.edit', ['booking' => $booking,'message'=>$message]);

      }catch(Exception $e){
        abort(500, $e->message());
      }
    }

        

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
      try{
        $obj = new Vehicle();
        $obj = $obj->findOrFail($id);
        $obj->name = $request->input('name');
        $obj->vehicle_number = $request->input('vehicle_number');
        $obj->vehicle_type_id = $request->input('vehicle_type_id');
        //$pageData->slug = $request->input('slug');
        $obj->rate_per_km = $request->input('rate_per_km');
        
        //print_r($_FILES); die;
        
        $obj->save();
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', '"'.$request->input('name').'" vehicle updated successfully');
        return redirect('vehicles');
      }catch(Exception $e){
        abort(500, $e->message());
      }

    }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\User  $user
    * @return \Illuminate\Http\Response
    */
   public function destroy(Request $request, $id)
   {
     try{
       $obj = new Vehicle();
       $obj = $obj->findOrFail($id);
       //print_r($userData); die;
       if($obj->count()>0){
         //@unlink($obj->file_path);
         $obj->delete();
         Vehicle::where('id',$id)->delete();
         $request->session()->flash('message.level', 'success');
         $request->session()->flash('message.content', 'Vehicle deleted successfully');
         return redirect()->action('VehicleController@index');
       }else{
         $request->session()->flash('message.level', 'error');
         $request->session()->flash('message.content', 'Vehicle not found');
         return redirect()->action('VehicleController@index');
       }
       
     }catch(Exception $e){
       abort(500, $e->message());
     }

     //return view('users.index', ['users' => $users->getAllUser()]);
   }
   
   public function sendNotification(Request $request){
       //echo 'ddddd';die;
      try{
       $booking_msg = $request->booking_msg;
       $booking_id = $request->booking_id;
       $notificationObj = new Notification();
       $notificationObj->booking_id = $booking_id;
       $notificationObj->notification = $booking_msg;
       $result = Booking::with(['user','vehicle'])->where('id',$booking_id)->first();
       echo ($result); die;
       if($result){
            if($notificationObj->save()){
             if(empty($result->user->device_id)){
                 echo '0'; die;
             }    
             define( 'API_ACCESS_KEY', 'AIzaSyAzmhj5OyGIF3eOEL9rhqM3x9XkBT0DxDE' );
             $registrationIds = [$result->user->device_id];
            // prep the bundle
            $msg = array
            (
            	'message' 	=> $booking_msg,
            	'title'		=> 'Tempowala update for bookingID '.$result->bookingID,
            	'sound'		=> 1
            );
            $fields = array
            (
            	'registration_ids' 	=> $registrationIds,
            	'data'			=> $msg
            );
             
            $headers = array
            (
            	'Authorization: key=' . API_ACCESS_KEY,
            	'Content-Type: application/json'
            );
             
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
            $result = curl_exec($ch );
            curl_close( $ch );  
             echo '1';
           }else{ echo '0';}   
       }else{
           echo '0';
       }
       
     }catch(Exception $e){
       abort(500, $e->message());
     } 
   }
   
   public function getNotification(Request $request){
       $booking_id = $request->booking_id;
       $bookingData = Notification::where('booking_id',$booking_id)->get();
       echo json_encode($bookingData); die;
   }
}
