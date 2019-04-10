<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailDemande extends Model
{
    protected $guarded=['id'];

    public function demandes(){
        return $this->hasMany('App\Demande');
    }

    public function sortieStock(){
        return $this->belongsTo('App\SortieStock');
    }
}
