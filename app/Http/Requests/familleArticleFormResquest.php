<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class familleArticleFormResquest extends FormRequest
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
            'famille'=>'required|min:3|max:100'
        ];
    }
    public function messages()
    {
        return [
          'famille.required'=>'Le champ famille est obligatoire',
          'famille.unique'=>'Le champ famille est unique',
            'famille.min'=>'Il faut saisir au moins trois caractere',
            'famille.max'=>'Vous n\'êtes pas autoriser à depasser cent caracteres'

        ];
    }
}
