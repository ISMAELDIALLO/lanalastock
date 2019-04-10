<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SortieStock extends Model
{
    protected $guarded=['id'];

    public function detailDemande(){
        return $this->hasMany('App\DetailDetail');
    }
}
