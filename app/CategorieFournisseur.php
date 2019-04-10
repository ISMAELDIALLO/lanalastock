<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategorieFournisseur extends Model
{
    protected $guarded=['id'];
    public function fournisseur(){
        return $this->hasMany('App\Fournisseur');
    }
}
