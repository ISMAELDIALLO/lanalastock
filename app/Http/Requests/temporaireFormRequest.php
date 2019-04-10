<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class temporaireFormRequest extends FormRequest
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
            'article'=>'required',
            'quantite'=>'required|integer'
        ];
    }
    public function messages()
    {
        return [
            'article.required'=>'L article est obligatoire',
            'quantite.required'=>'La quantite est requise',
            'quantite.integer'=>'La quantite de prend pas de telles valeurs veuillez diminué/ ramernez en entier'
        ];
    }
}
