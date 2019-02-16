<?php

namespace App\Http\Controllers\User;

use App\Action;
use App\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return view('User.index');
    }

    public function control()
    {
        $actions = Action::all();
        $event = Event::where('user_id',auth()->user()->id)->pluck('action_id');
//        return $event;
        return view('User.control', compact('actions','event'));
    }

    public function income()
    {
        return view('User.income');
    }

    public function active()
    {
        return view('User.active');
    }

    public function setevent(Request $request)
    {
//            return $request;
        if (is_array($request->actions) ) {

            foreach ($request->actions as $action) {
                $record = new Event();
                $record->user_id = Auth::user()->id;
                $record->action_id = $action;
                $record->save();
            }

        }
        return redirect()->back();
    }

    public function setincome()
    {

    }

    public function setactive()
    {

    }
}
