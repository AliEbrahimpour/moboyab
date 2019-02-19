<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserWallet extends Model
{
//    public function scopeSpanningUserWallet($query , $month , $status)
//    {
//        $query->selectRaw('monthname(created_at) month , count(*) type')
//            ->where('created_at' , '>' , Carbon::now()->subMonth($month))
//            ->wherePayment($status)
//            ->groupBy('month')
//            ->latest();
//    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function incomefilter($status,$type)
    {
        return $income = UserWallet::with('User')->
        whereType($type)->whereStatus($status);

//        $user = User::whereId(\auth()->user()->id)->first();
//         $income;
//        return $income->whereStatus('waiting')->whereType('deposit')->sum('amount');
    }

}
