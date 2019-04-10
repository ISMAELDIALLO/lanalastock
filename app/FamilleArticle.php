<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FamilleArticle extends Model
{
    protected $guarded=['id'];
    public function articles(){
        return $this->hasMany('App\Article');
    }

}
