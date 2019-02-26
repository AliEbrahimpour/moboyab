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


}
