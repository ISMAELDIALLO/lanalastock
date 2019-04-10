<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class articleFormResquest extends FormRequest
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
            'libelle'=>'required',
            'famille'=>'required',
            'quantiteminimum'=>'required|integer',
            'quantitemaximum'=>'required|integer'
        ];
    }
    public function messages()
    {
        return [
            'famille.required'=>'Vous devrez remplir au moins une famille d\'article',
          'libelle.required'=>'Le libelle est obligatoire',
          'libelle.min'=>'Le libelle doit avoir au moins deux caractères',
          'libelle.max'=>'Le libelle ne doit pas depasser cent caractères',
            'quantiteminimum.required'=>'La quanite est obligatoire',
            'quantiteminimum.integer'=>'La quanite doit être saisie avec des chiffres',
            'quantitemaximum.required'=>'La quanite est obligatoire',
            'quantitemaximum.integer'=>'La quanite doit être saisie avec des chiffres'
        ];
    }
}
