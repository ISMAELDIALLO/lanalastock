<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class motifFormResquest extends FormRequest
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
            'motif'=>'required|min:3'
        ];
    }
    public function messages()
    {
        return [
            'motif.required'=>'Le motif est recquis',
            'motif.min'=>'Il faut trois caractères au moins'
        ];
    }
}
