<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    protected $guarded=['id'];
    public function categorieFournisseur(){
        return $this->belongsTo('App\CategorieFournisseur');
    }
}
