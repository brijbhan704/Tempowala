<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Classes\UploadFile;
use App\Vehicle;
use App\VehicleType;

class VehicleController extends Controller
{
    /*
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   private $_vehicleTableName = 'Vehicle';   
   private $_vehicleView = 'vehicles';
   public function index()
   {
                        
       try{
         $cat = Vehicle::where('id','<>',0)->get();

         $obj = Vehicle::paginate(config('app.paging'));
         //echo '<pre>'; print_r($uesrs); die;
         return view($this->_vehicleView.'.index', [$this->_vehicleView => $obj]);
       }catch(Exception $e){
         abort(500, $e->message());
       }
   }

   

   public function vehicleIndexAjax(Request $request){
    
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
         $obj = Vehicle::with(['vehicle_type'])->whereRaw('1 = 1');

         
         if ($request->search['value'] != "") {            
           $obj = $obj->where('name','LIKE',"%".$search."%");
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
        $type = VehicleType::where('id','<>',0)->get();  
        $obj = new Vehicle();
        $objData = $obj->findOrFail($id);
        
        return view('vehicles.edit', ['vehicle' => $objData,'type'=>$type]);

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
}
