<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class categorieFournisseurFormResquest extends FormRequest
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
            'categorie'=>'required|min:2|max:100'
        ];
    }
    public function messages()
    {
        return [
            'categorie.required'=>'La gatégorie est obligatoire',
            'categorie.min'=>'La gatégorie doit avoir au moins deux caractères',
            'categorie.max'=>'La gatégorie ne doit pas depasser cent caractères'
        ];
    }
}
