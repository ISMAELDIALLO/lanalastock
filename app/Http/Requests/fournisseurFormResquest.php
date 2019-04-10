<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class fournisseurFormResquest extends FormRequest
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
            'categorie'=>'required',
            'nomSociete'=>'required|min:2|max:100',
            'nomContact'=>'required|min:2|max:100',
            'prenomContact'=>'required|min:2|max:100',
            'telephone'=>'required|min:9|max:15'
        ];
    }
    public function messages()
    {
        return [
            'categorie.required'=>'Vous devez avoir au moins une categorie de  fournisseur',
            'nomSociete.required'=>'Le nom du societe qui fourni est recquis',
            'nomSociete.min'=>'Le nom de la societe doit avoir au moins deux caractères',
            'nomSociete.max'=>'Le nom de la societe ne doit pas depasser cent caractères',
            'nomContact.required'=>'Le nom du contact est recquis',
            'nomContact.min'=>'Le nom du contact doit avoir au moins deux caractères',
            'nomContact.max'=>'Le nom du contact ne doit pas depasser cent caractères',
            'prenomContact.required'=>'Le prenom du contact est recquis',
            'prenomContact.min'=>'Le prenom du contact doit avoir au moins deux caractères',
            'prenomContact.max'=>'Le prenom du contact ne doit pas depasser cent caractères',
            'telephone.required'=>'Le telephone du contact est recquis',
            'telephone.min'=>'Le telephone du contact doit contenir au moins neufs caractères',
            'telephone.max'=>'Le telephone du contact ne doit pas deppasser 15 caractère'
        ];
    }
}
