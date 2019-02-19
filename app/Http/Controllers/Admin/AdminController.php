<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\UserWallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(){

        return view('Admin.index');
    }

    public function checkout(UserWallet $userWallet){

        $waiting = $userWallet->incomefilter('waiting','harvest')->get();
        return view('Admin.checkout',compact('waiting'));
    }

    public function activety(){
        $callers  = DB::table('user_wallets')
            ->leftJoin('users', 'user_id', '=', 'users.id')
            ->paginate(5);

        $users  = DB::table("users")->select('*')->whereNotIn('id',function($query) {
            $query->select('user_id')->from('user_wallets');
        })->paginate(5);

        return view('Admin.activety',compact('users','callers'));
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
