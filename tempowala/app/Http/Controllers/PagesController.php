<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Exceptions\Handler;
use Illuminate\Support\Facades\DB;
//use Carbon\Carbon;

class TowerController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      try{
        

        //select role_id, count(role_id) AS count FROM users GROUP BY role_id HAVING role_id > 1


        $ip = \Request::ip();
        $visit_date = date('Y-m-d');

        $visitor = Visitor::firstOrCreate(['ip'=>$ip,'visit_date'=>$visit_date]);
        
        if($visitor->visit_date != date('Y-m-d')){
          $visitor->hits = $visitor->hits+1;
          $visitor->visit_date = $visit_date;
          $visitor->save();
        }
               

        $visitorObj = new Visitor();
        $visitorCount = $visitorObj->getVisitorCount(); 
        
        
        //echo '<pre>';print_r($data[1]->role_count); die;        
        return view('pages.index',[
        'visitor_count'=>$visitorCount
        ]);
      }catch(Exception $e){
        abort(500, $e->message());
      }
    }

    
}
