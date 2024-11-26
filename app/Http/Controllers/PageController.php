<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function welcome(){
        return view("Home");
    }
    public function createForm(){
        return view("createForm");
    }
}
