<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthApiController extends Controller
{
    public function Register(Request $request){
        $userData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        // $userData =$request->validate([
        //     'name'=> $request->name,
        //     'email'=> $request->email,
        //     'password'=> bcrypt($request->password),
        // ]);
        
        try{
            $user = User::create($userData);
        }catch(\Exception $e){
            return response(['error'=>$e->getMessage()],404);
        }
        $token = $user->createToken('MyApp')->accessToken;
        return response()->json(['user' =>$user,'accesstoken'=>$token],201);
        // Continue with registration logic
    }
    public function Login(Request $request){
        $userData = $request->validate([
            'email'=> 'required|email',
            'password'=> 'required'
        ]);
        if(!auth()->attempt($userData)){
            return response()->json(['error'=> 'Credentials is not valid'],401);
        }
        $user = auth()->user();
        $token = $user->createToken('MyApp')->accessToken;
        return response()->json(['user'=>$user,'accesstoken'=>$token],200);
    }
}