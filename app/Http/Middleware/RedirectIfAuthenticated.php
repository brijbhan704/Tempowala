<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;


class RedirectIfAuthenticated
{

     public function authenticate()
     {
        
       //echo "comind"; die;
         if (Auth::attempt(['email' => $email, 'password' => $password])) {
             // Authentication passed...
             return redirect()->intended('dashboard');
         }
     }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        
       $request->email = openssl_decrypt(base64_decode($request->email),"AES-128-CBC",'201707eggplant99',OPENSSL_RAW_DATA,'1234567890123412'); 
       $request->password = openssl_decrypt(base64_decode($request->password),"AES-128-CBC",'201707eggplant99',OPENSSL_RAW_DATA,'1234567890123412'); 
        $request->merge([
            'email' => $request->email,
            'password' => $request->password           
        ]);

        if (Auth::guard($guard)->check()) {             
            return redirect('/');
        }
        
        // if (Auth::user()->role == 1) {
        //     return redirect('/');
        // }else{
        //         return redirect('/'.Auth::user()->role);
        // }
        return $next($request);
    }
}
