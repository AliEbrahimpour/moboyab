<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index(){
        return view('Admin.index');
    }

    public function checkout(){
        return view('Admin.checkout');
    }

    public function activety(){
        return view('Admin.activety');
    }

    public function blog(){
        return view('Admin.blog');
    }

    public function ticket(){
        return view('Admin.ticket');
    }

    public function gallery(){
        return view('Admin.gallery_admin');
    }

}
