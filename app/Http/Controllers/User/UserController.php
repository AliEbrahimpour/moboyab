<?php

namespace App\Http\Controllers\User;

use App\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(){
        return view('User.index');
    }

    public function control(){
        return view('User.control');
    }

    public function income(){
        return view('User.income');
    }
    public function active(){
        return view('User.active');
    }
    public function setevent(Request $request){
        $record=  new Event();
        $record->user_id = Auth::user()->id;
        

        $record->save();
        return redirect()->back();
    }

    public function setincome(){

    }

    public function setactive(){

    }
}
