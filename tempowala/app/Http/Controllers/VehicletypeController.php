<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Classes\UploadFile;
use App\Vehicle;
use App\VehicleType;

class VehicletypeController extends Controller
{
    /*
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   private $_vehicleTableName = 'VehicleType';   
   private $_vehicleView = 'vehicletypes';
   public function index()
   {
                        
       try{
         $cat = VehicleType::where('id','<>',0)->get();

         $obj = VehicleType::paginate(config('app.paging'));
         //echo '<pre>'; print_r($uesrs); die;
         return view($this->_vehicleView.'.index', [$this->_vehicleView => $obj]);
       }catch(Exception $e){
         abort(500, $e->message());
       }
   }

   

   public function vehicleTypeIndexAjax(Request $request){
    
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
         $obj = VehicleType::whereRaw('1 = 1');

         
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
        
        $obj = new VehicleType();       
        $obj->name = $request->input('name');
        $obj->capacity = $request->input('capacity');
        $obj->base_price = $request->input('base_price');
        $obj->rate_per_km = $request->input('rate_per_km');
        $obj->rate_2_to_5_km = $request->input('rate_2_to_5_km');
        $obj->rate_gt_6_km = $request->input('rate_gt_6_km');
        
        if(isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])){
          $upload_handler = new UploadFile();
          $path = public_path('uploads/vehicleTypes'); 
          $data = $upload_handler->upload($path,'vehicleTypes');
          $res = json_decode($data);
          if($res->status=='ok'){
            $obj->image = $res->path;
            $obj->path = $res->img_path;
          }else{
            $request->session()->flash('message.level', 'error');
            $request->session()->flash('message.content', $res->message);
            return redirect('vehicletypes/add');
          }
        }
        
        if($obj->save()){
          $request->session()->flash('message.level', 'success');
          $request->session()->flash('message.content', '"'.$request->input('name').'" added successfully');
          return redirect('vehicletypes');
        }else{
          $request->session()->flash('message.level', 'error');
          $request->session()->flash('message.content', '"'.$request->input('name').'" not added');
          return redirect('vehicletypes');
        }
       }else{
        return view('vehicletypes.add', []); 
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
        
        $obj = new VehicleType();
        $objData = $obj->findOrFail($id);
        
        return view('vehicletypes.edit', ['vehicleType' => $objData]);

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
        $obj = new VehicleType();
        $obj = $obj->findOrFail($id);
        $obj->name = $request->input('name');
        $obj->capacity = $request->input('capacity');
        $obj->base_price = $request->input('base_price');
        $obj->rate_per_km = $request->input('rate_per_km');
        $obj->rate_2_to_5_km = $request->input('rate_2_to_5_km');
        $obj->rate_gt_6_km = $request->input('rate_gt_6_km');
        
        if(isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])){
          $upload_handler = new UploadFile();
          $path = public_path('uploads/vehicleTypes'); 
          $data = $upload_handler->upload($path,'vehicleTypes');
          $res = json_decode($data);
          if($res->status=='ok'){
            @unlink($obj->file_path);
            $obj->image = $res->path;
            $obj->path = $res->img_path;
          }else{
            $request->session()->flash('message.level', 'error');
            $request->session()->flash('message.content', $res->message);
            return redirect('vehicletypes/edit/'.$id);
          }
        }
        
        $obj->save();
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', '"'.$request->input('name').'" vehicle type updated successfully');
        return redirect('vehicletypes');
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
       $obj = new VehicleType();
       $obj = $obj->findOrFail($id);
       //print_r($userData); die;
       if($obj->count()>0){
         //@unlink($obj->file_path);
         $obj->delete();
         VehicleType::where('id',$id)->delete();
         $request->session()->flash('message.level', 'success');
         $request->session()->flash('message.content', 'Vehicle type deleted successfully');
         return redirect()->action('VehicletypeController@index');
       }else{
         $request->session()->flash('message.level', 'error');
         $request->session()->flash('message.content', 'Vehicle type not found');
         return redirect()->action('VehicletypeController@index');
       }
       
     }catch(Exception $e){
       abort(500, $e->message());
     }

     //return view('users.index', ['users' => $users->getAllUser()]);
   }
}
