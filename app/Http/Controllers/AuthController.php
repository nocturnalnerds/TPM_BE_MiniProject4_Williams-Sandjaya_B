<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller{
    public function viewRegister(){
        return view('auth.register');
    }
    public function register(Request $request){
        try{
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|max:255|unique:users',
                'password' => 'required|min:8',
            ]);
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            return redirect()->route('login')->with('success', 'register successful!');
        }catch(\Exception $e){
            dump($e);
            sleep((1000));
            return back()->withErrors('error', 'error occured, check input!');
        }
    }
    public function viewLogin(){
        return view('auth.login');
    }
    public function login(Request $request){
        try{
            $request->validate([
                'email'=> 'required|string|max:255',
                'password'=> 'required|string',
            ]);
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                // dump('SUCCESS!');
                $request->session()->regenerate();
                return redirect()->route('notes.index')->with('success', 'Login successful!');
                
            } else {
                // dump("ERROR DI SINI");
                sleep(1000);
                return back()->withErrors(['email' => 'Invalid credentials.']);
            }
        }catch(\Exception $e){
            dump($e);
        }
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success','');
    }
}