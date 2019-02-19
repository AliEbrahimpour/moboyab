<?php

namespace App\Http\Controllers\User;

use App\Action;
use App\Event;
use App\UserWallet;
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
        $event = Event::where('user_id',auth()->user()->id)->pluck('action_id')->toArray();
//        return $event;

        return view('User.control', compact('actions','event'));
    }


    public function income(UserWallet $userWallet)
    {
        $waiting = $userWallet->incomefilter('waiting','deposit')->whereCallerId(\auth()->user()->id);
        $accept = $userWallet->incomefilter('accept','deposit')->whereCallerId(\auth()->user()->id);
        return view('User.income',compact('waiting','accept'));
    }


    public function active()
    {
        $events = Event::whereUserId(\auth()->user()->id)->get();
        return view('User.active',compact('events'));
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
