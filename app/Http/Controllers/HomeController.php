<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    //=============================================================================
    public function home(){
        $active_subjects = Subject::active()->get();
        return view('home',compact('active_subjects'));
    }
    //=============================================================================
}