<?php

namespace App\Http\Controllers\Admin;

use App\Blog;
use App\RoberFace;
use App\Ticket;
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
            ->paginate(10);

        $users  = DB::table("users")->select('*')->whereNotIn('id',function($query) {
            $query->select('user_id')->from('user_wallets');
        })->paginate(5);

        $bests = DB::table('user_wallets')
            ->select(DB::raw('caller_id , count(*) as user_count'))
            ->groupBy('caller_id')->orderByDesc('user_count')->get();

        return view('Admin.activety',compact('users','callers','bests'));
    }


    public function control(){
        $bests = DB::table('events')
            ->select(DB::raw('action_id , count(*) as action_count'))
            ->groupBy('action_id')->orderByDesc('action_count')->get();

        return view('Admin.control',compact('bests'));
    }

    public function blog(){
        return view('Admin.blog');
    }

    public function setblog(Request $request){
        $record = new Blog($request->except('_token'));
        $record->save();
        return redirect()->back();
    }

    public function ticket(){
        $tickets = Ticket::paginate(5);
        return view('Admin.ticket',compact('tickets'));
    }

//    public function setticket(Request $request){
//        return $request;
//    }

    public function gallery(){
        $rfs = RoberFace::paginate(6);
        return view('Admin.gallery_admin',compact('rfs'));
    }

}
