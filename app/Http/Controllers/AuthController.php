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
                'role' => 'user',
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
                $request->session()->regenerate();

                $user = Auth::user();
                session(['role' => $user->role, 'userId' => $user->id]);
                if ($user->role === 'admin') {
                    return redirect()->route('storage.index')->with('success', 'Welcome Admin!');
                } else {
                    return redirect()->route('storage.index')->with('success', 'Login successful!');
                }
                return redirect()->route('storage.index')->with('success', 'Login successful!');
                
            } else {
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