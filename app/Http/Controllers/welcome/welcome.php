<?php

namespace App\Http\Controllers\welcome;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class welcome extends Controller
{
    // Show the main welcome page
    public function index(){
        return view('welcome.welcome');
    }

    // Show the about page
    public function about(){
        return view('welcome.about');
    }

    // Show the privacy policy page
    public function privacy(){
        return view('welcome.privacy');
    }

    // Show the terms and conditions page
    public function terms(){
        return view('welcome.terms');
    }
}
