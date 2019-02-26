<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable=['title','description','body','images_one','images_two','images_three','news_status'];
    public $timestamps=false;
}
