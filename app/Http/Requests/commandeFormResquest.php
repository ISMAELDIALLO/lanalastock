<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class commandeFormResquest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fournisseur'=>'required',
            'dateCommande'=>'required|min:10|max:12'
        ];
    }
    public function messages()
    {
        return [
            'fournisseur.required'=>'Le fourniture est obligatoire pour enregistrer une commande',
            'dateCommande.required'=>'La date est recquise',
            'dateCommande.min'=>'Le minimum de la saisie d\'une date est douze caractères',
            'dateCommande.max'=>'Le maximum de la saisie d\'une date est douze caractères'
        ];
    }
}
