<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Message;
use App\User;
use App\Notification;
use DB;

class MessageController extends Controller
{
    /*
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   private $_vehicleTableName = 'Message';   
   private $_vehicleView = 'messages';
   public function index()
   {
                        
       try{
         //$cat = Booking::where('id','<>',0)->get();

         $obj = Message::where('id','<>',0)->paginate(config('app.paging'));
         //echo '<pre>'; print_r($uesrs); die;
         return view($this->_vehicleView.'.index', [$this->_vehicleView => $obj]);
       }catch(Exception $e){
         abort(500, $e->message());
       }
   }

   

   public function messageIndexAjax(Request $request){
       
    
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
         //echo $start;die;
         $search = ($request->search['value']) ? $request->search['value'] : '';
         //echo $search;die;
         $cond[] = [];
         //echo '<pre>'; print_r($users); die; categoryFilter
         $obj = Message::whereRaw('1 = 1');

         
         if ($request->search['value'] != "") {            
           $obj = $obj->where('title','LIKE',"%".$search."%");
         } 
               //echo $obj;die;
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
       
       if($request->isMethod('post')){

        $validator = Validator::make($request->all(), [
          'title' => 'required|string',
          'description' => 'required|string',
        ]);
        
        //$validator->errors()
        if($validator->fails()){
          $request->session()->flash('message.level', 'error');
          $request->session()->flash('message.content', $validator->errors());
          return redirect('messages');
          
        }
        //print_r($_FILES); die;
        
        $obj = new Message();       
        $obj->title = $request->input('title');
        $obj->type = $request->input('type');
        $obj->description = $request->input('description');
        
        if(Message::where('title',$obj->title)->count()){
            $request->session()->flash('message.level', 'error');
            $request->session()->flash('message.content', '"'.$request->input('title').'" already exists!');
            return redirect('messages');
        }
        
        if($obj->save()){
          $request->session()->flash('message.level', 'success');
          $request->session()->flash('message.content', '"'.$request->input('title').'" added successfully');
          return redirect('messages');
        }else{
          $request->session()->flash('message.level', 'error');
          $request->session()->flash('message.content', '"'.$request->input('title').'" not added');
          return redirect('messages');
        }
       }else{
        return view('messages.add', []); 
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
        $message = Message::where('id',$id)->first();
        //echo '<pre>'; print_r($booking);
        if(!$message->count()){
            return redirect('messages');
        }
        
        return view('messages.edit', ['message' => $message]);

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
        $obj = new Message();
        $obj = $obj->findOrFail($id);
        $obj->title = $request->input('title');
        $obj->type = $request->input('type');
        $obj->description = $request->input('description');
        
        if(Message::where([['title',$obj->title],['id','<>',$id]])->count()){
            $request->session()->flash('message.level', 'error');
            $request->session()->flash('message.content', '"'.$request->input('title').'" already exists!');
            return redirect('messages');
        }
        
        $obj->save();
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', '"'.$request->input('title').'" updated successfully');
        return redirect('messages');
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
       $obj = new Message();
       $obj = $obj->findOrFail($id);
       //print_r($userData); die;
       if($obj->count()>0){
         //@unlink($obj->file_path);
         $obj->delete();
         Message::where('id',$id)->delete();
         $request->session()->flash('message.level', 'success');
         $request->session()->flash('message.content', 'Message deleted successfully');
         return redirect()->action('MessageController@index');
       }else{
         $request->session()->flash('message.level', 'error');
         $request->session()->flash('message.content', 'Message not found');
         return redirect()->action('MessageController@index');
       }
       
     }catch(Exception $e){
       abort(500, $e->message());
     }

     //return view('users.index', ['users' => $users->getAllUser()]);
   }
   
   public function getMessageById(Request $request){
       try{
            $msg = Message::where('id',$request->id)->first();
            echo $msg->description; die;
           }catch(Exception $e){
           abort(500, $e->message());
         }
   }
   
   public function send_message(Request $request){
       try{
           if ($request->isMethod('post'))
            {
                
                $validator = Validator::make($request->all(), [
                  'title' => 'required|string',
                  'description' => 'required|string',
                  'userlist' => 'required'
                ]);
                
                //$validator->errors()
                if($validator->fails()){
                  $request->session()->flash('message.level', 'error');
                  $request->session()->flash('message.content', $validator->errors());
                  return redirect('messages');
                  
                }
                //$ids = implode(",",$request->userlist); 
        
                $devices = User::select(DB::raw('GROUP_CONCAT(device_id) as deviceID'))->whereIn('id', $request->userlist)->get();
                //echo print_r($devices[0]->deviceID); die;
                
                $deviceArr = explode(",",$devices[0]->deviceID);    
                define( 'API_ACCESS_KEY', 'AIzaSyAzmhj5OyGIF3eOEL9rhqM3x9XkBT0DxDE' );
                $registrationIds = $deviceArr;
                // prep the bundle
                $msg = array
                (
                	'message' 	=> $request->description,
                	'title'		=> $request->title,
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
                $request->session()->flash('message.level', 'success');
                $request->session()->flash('message.content', 'Message sent successfully');
                return redirect()->action('MessageController@send_message');
            }
            $userList = User::select("id","name","email","phone")->where('device_id','<>','')->get();
            $messageList = Message::where('type','promotion')->get();
            return view('messages.send_message', ['messageList'=>$messageList,'userList'=>$userList]);
            
           }catch(Exception $e){
           abort(500, $e->message());
         }
   }
}
