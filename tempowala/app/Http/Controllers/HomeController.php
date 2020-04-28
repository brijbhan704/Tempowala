<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Booking;
use App\User;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {        
        $this->middleware('auth');
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        
        //$event = Event::all()->count(); 
        //$trainer = User::where('role_id',3)->count(); 
        $user = User::where('role_id',2)->count(); 
        $salesArr = Booking::select(DB::raw("YEAR(created_at) AS y,MONTHNAME(created_at) AS m,SUM(`price`) as price"))
        ->groupBy("m")
        ->get();
        $monthArr = [];
        $priceArr = [];
        if($salesArr->count()){
            foreach($salesArr as $v){
                array_push($monthArr,$v->m);
                array_push($priceArr,$v->price);
                
            }
        }
        
        $bookingArr = Booking::select(DB::raw("YEAR(created_at) AS y,MONTHNAME(created_at) AS m,count(`id`) as id"))
        ->groupBy("m")
        ->get();
        $monthBookArr = [];
        $priceBookArr = [];
        if($bookingArr->count()){
            foreach($bookingArr as $v){
                array_push($monthBookArr,$v->m);
                array_push($priceBookArr,$v->id);
                
            }
        }
        //print_r($monthArr); die;
        //SELECT YEAR(created_at) AS y, MONTHNAME(created_at) AS m, SUM(`price`) FROM bookings GROUP BY m
        return view('home', compact('user','monthArr','priceArr','monthBookArr','priceBookArr'));
        //return view(['home']);
    }
}
