<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Contracts\Auth\Authenticatable;
use Socialite;
use Auth;

class GoogleController extends Controller
{
    
   protected $redirectTo = '/';
     
    public function __construct() {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }
     
     public function redirectToProvider() {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback(Request $request) {
        
        if($request->error){
                 return redirect($this->redirectTo);
        }
        else{
            
        
        
        $user = Socialite::driver('google')->user();
        $user_acc = User::where("email", $user->getEmail())->first();
        if (!isset($user_acc)):
            User::create([
                "name" => $user->getName(),
                "email" => $user->getEmail(),
                "password" => bcrypt($user->getEmail())
            ]);
            $email = $user->getEmail();
            $password = $user->getEmail();
            
            if (Auth::attempt(['email' => $email, 'password' => $password])):
                 // Authentication passed...
                return redirect($this->redirectTo);
            endif;
               
        else:
            $email = $user->getEmail();
                $user= User::where('email',$email)->first();      
              if(!$empty($user->id)){
                  $id=$user->id;
                 Auth::loginUsingId($id, true);
                // Authentication passed...
                return redirect($this->redirectTo);
         
              }else {
                   return redirect()->back();
              }
              
        endif;
       }
    }

   
}
