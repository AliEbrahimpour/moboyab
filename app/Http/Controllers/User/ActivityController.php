<?php

namespace App\Http\Controllers\User;

use App\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivityController extends Controller
{
    public function active()
    {
        $events = Event::whereUserId(\auth()->user()->id)->get();
        return view('User.active',compact('events'));
    }
}
