<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $guarded=['id'];
    public function fournisseurs(){
        return $this->hasMany('App\Fournisseur');
    }
}
