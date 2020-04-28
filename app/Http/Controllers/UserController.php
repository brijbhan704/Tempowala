<?php

namespace App\Http\Controllers;

use App\User;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Traits\SendMail;
use Config;
use Mail;
//use Carbon;
//use App\Mail\WelcomeMail;
//use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    //use SendMail;
    
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
                  
        try{
          

          $uesrs = User::where([['status', '1'],['role_id','<>',1]])->paginate(config('app.paging'));
          //echo '<pre>'; print_r($uesrs); die;
          return view('users.index', ['users' => $uesrs]);
        }catch(Exception $e){
          abort(500, $e->message());
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function changepass(Request $request)
    {                  
        try{
          $user  = JWTAuth::user();                    
          if ($request->isMethod('post')) {
                                                                         
            if($user->count()>0){              
              if($request->new_password != $request->confirm_password){
                $request->session()->flash('message.level', 'error');
                $request->session()->flash('message.content', 'Password and confirm password is not same');
                return redirect()->action('UserController@change_password');
              }              
              if(!Hash::check($request->old_password, $user->password)){
                $request->session()->flash('message.level', 'error');
                $request->session()->flash('message.content', 'Old password is incorrect');
                return redirect()->action('UserController@change_password');
              }else{            
                User::where('email', $user->email)->update(['password'=>Hash::make($request->new_password)]);                   
                $request->session()->flash('message.level', 'success');
                $request->session()->flash('message.content', 'Password changed successfully');
                return redirect()->action('UserController@index');  
              }
              
            }else{
              $request->session()->flash('message.level', 'error');
              $request->session()->flash('message.content', 'user not found');
              return redirect()->action('UserController@changepass');
            }   
             
          }         
          return view('users.change_password_page',['users'=>$user]);
        }catch(Exception $e){
          abort(500, $e->message());
        }
    }

    public function userIndexAjax(Request $request){
     
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
          $cond[] = ['role_id','<>',1];
          $users = User::with(['Role'])->where($cond);
          //echo '<pre>'; print_r($users); die;
          
          if ($request->search['value'] != "") {            
            $users = $users->where('email','LIKE',"%".$search."%")
            ->orWhere('name','LIKE',"%".$search."%")
            ->orWhere('phone','LIKE',"%".$search."%");
          } 

          $total = $users->count();
          if($end==-1){
            $users = $users->get();
          }else{
            $users = $users->skip($start)->take($end)->get();
          }
          
          $response["recordsFiltered"] = $total;
          $response["recordsTotal"] = $total;
          //response["draw"] = draw;
          $response["success"] = 1;
          $response["data"] = $users;
          
        } catch (Exception $e) {    

        }
      

      return response($response);
    }

   /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      
      try{
        Log::info('create new user profile for user:');

        $users = new Users();
        //$users = $users->findOrFail($id);
        //echo $id;
        $users->first_name = $request->input('first_name');
        $users->username = $request->input('username');
        $users->phone = $request->input('phone');
        $users->password = bcrypt($request->input('password'));
        $users->last_name  = $request->input('last_name');
        $users->email  = $request->input('email');
        $users->is_blocked = $request->input('is_blocked');
        $users->verification_code = '';
        $users->country_id = $request->input('country_id');
        $users->save();
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'User created successfully');
        return redirect()->action('UserController@index');
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
        $users = new Users();
        $userData = $users->findOrFail($id);
        //print_r($userData); die;
        if($userData->count()>0){
          $userData->delete();
          $request->session()->flash('message.level', 'success');
          $request->session()->flash('message.content', 'User deleted successfully');
          return redirect()->action('UserController@index');
        }else{
          $request->session()->flash('message.level', 'error');
          $request->session()->flash('message.content', 'User not found');
        }
        
      }catch(Exception $e){
        abort(500, $e->message());
      }

      //return view('users.index', ['users' => $users->getAllUser()]);
    }


    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function settings(Request $request, $id)
   {
     try{
       $id = $request->id;
       $settings = new Setting();
       $settingsData = $settings->findOrFail($id);
       if($request->isMethod('post')){
        $settingsData->id = 1;      
        $settingsData->admin_email = $request->admin_email;
        $settingsData->fb_link = $request->fb_link;
        $settingsData->twitter_link = $request->twitter_link;
        $settingsData->insta_link = $request->insta_link;
        $settingsData->terms_and_condition = $request->terms_and_condition;
        $settingsData->privacy_policy = $request->privacy_policy;
        $settingsData->save();

        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Record saved successfully');
        return redirect('users/settings/1');

       }else{
        return view('users.settings',['settings'=>$settingsData]); 
       }
              
     }catch(Exception $e){
       Log::info('settings add exception:='.$e->message());
       $response['message'] = 'Opps! Somthing went wrong';
       echo json_encode($response);
       abort(500, $e->message());
     }
   }

}