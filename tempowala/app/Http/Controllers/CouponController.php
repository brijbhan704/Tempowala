<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Coupon;

class CouponController extends Controller
{
    /*
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   private $_vehicleTableName = 'Coupon';   
   private $_vehicleView = 'coupons';
   public function index()
   {
                        
       try{
         //$cat = Booking::where('id','<>',0)->get();

         $obj = Coupon::where('id','<>',0)->paginate(config('app.paging'));
         //echo '<pre>'; print_r($uesrs); die;
         return view($this->_vehicleView.'.index', [$this->_vehicleView => $obj]);
       }catch(Exception $e){
         abort(500, $e->message());
       }
   }

   

   public function couponIndexAjax(Request $request){
    
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
         $obj = Coupon::whereRaw('1 = 1');

         
         if ($request->search['value'] != "") {            
           $obj = $obj->where('title','LIKE',"%".$search."%");
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
       
       if($request->isMethod('post')){

        $validator = Validator::make($request->all(), [
          'title' => 'required|string',
          'code' => 'required|string',
          'publish_date' => 'required|string',
          'expire_date' => 'required|string',
          'discount' => 'required|numeric'
        ]);
        
        //$validator->errors()
        if($validator->fails()){
          $request->session()->flash('message.level', 'error');
          $request->session()->flash('message.content', $validator->errors());
          return redirect('messages');
          
        }
        //print_r($_FILES); die;
        
        $obj = new Coupon();       
        $obj->title = $request->input('title');
        $obj->code = $request->input('code');
        $obj->discount = $request->input('discount');
        $obj->publish_date = $request->input('publish_date');
        $obj->expire_date = $request->input('expire_date');
        
        if(Coupon::where('title',$obj->title)->count()){
            $request->session()->flash('message.level', 'error');
            $request->session()->flash('message.content', '"'.$request->input('title').'" already exists!');
            return redirect('coupons');
        }
        
        if($obj->save()){
          $request->session()->flash('message.level', 'success');
          $request->session()->flash('message.content', '"'.$request->input('title').'" added successfully');
          return redirect('coupons');
        }else{
          $request->session()->flash('message.level', 'error');
          $request->session()->flash('message.content', '"'.$request->input('title').'" not added');
          return redirect('coupons');
        }
       }else{
        return view('coupons.add', []); 
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
        $coupon = Coupon::where('id',$id)->first();
        //$coupon->publish_date = date('d/m/Y',strtotime($coupon->publish_date));
        //$coupon->expire_date = date('d/m/Y',strtotime($coupon->expire_date)); 
        //echo '<pre>'; print_r($booking);
        if(!$coupon->count()){
            return redirect('coupons');
        }
        
        return view('coupons.edit', ['coupon' => $coupon]);

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
        $obj = new Coupon();
        $obj = $obj->findOrFail($id);
        $obj->title = $request->input('title');
        $obj->code = $request->input('code');
        $obj->discount = $request->input('discount');
        $obj->publish_date = date('Y-m-d',strtotime($request->input('publish_date')));
        $obj->expire_date = date('Y-m-d',strtotime($request->input('expire_date')));
        
        if(Coupon::where([['title',$obj->title],['id','<>',$id]])->count()){
            $request->session()->flash('message.level', 'error');
            $request->session()->flash('message.content', '"'.$request->input('title').'" already exists!');
            return redirect('coupons');
        }
        
        $obj->save();
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', '"'.$request->input('title').'" updated successfully');
        return redirect('coupons');
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
       $obj = new Coupon();
       $obj = $obj->findOrFail($id);
       //print_r($userData); die;
       if($obj->count()>0){
         //@unlink($obj->file_path);
         $obj->delete();
         Coupon::where('id',$id)->delete();
         $request->session()->flash('message.level', 'success');
         $request->session()->flash('message.content', 'Message deleted successfully');
         return redirect()->action('CouponController@index');
       }else{
         $request->session()->flash('message.level', 'error');
         $request->session()->flash('message.content', 'Message not found');
         return redirect()->action('CouponController@index');
       }
       
     }catch(Exception $e){
       abort(500, $e->message());
     }

     //return view('users.index', ['users' => $users->getAllUser()]);
   }
   
   
}
