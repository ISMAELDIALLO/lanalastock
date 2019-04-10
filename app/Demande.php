<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    protected $guarded=['id'];

    public  function utilisateurs(){
        return $this->hasMany('App\Utilisateur');
    }
    public  function detailDemandes(){
        return $this->belongsTo('App\DetailDemande');
    }
}
