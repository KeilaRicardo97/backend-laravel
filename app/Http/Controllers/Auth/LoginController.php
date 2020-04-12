<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
  public function login(Request $request){
      $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required'
      ]);
      if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
        $verified = auth()->user()->verified;
        
        if($verified == 0){
          return response()->json(['data' => 'usuario no verificado', "ok" => "false"], 401);
        }else{
          $id = auth()->user()->id;
          $users = User::findOrFail($id);
         // $accessToken = $users->createToken('authToken')->accessToken;
 
           return response()->json(['data' => auth()->user(), "token"=>'en proceso', "ok" => "true"], 201);
        }
          
      }
      return response()->json(['message'=>"credenciales incorrectas"], 201);

  }
}
