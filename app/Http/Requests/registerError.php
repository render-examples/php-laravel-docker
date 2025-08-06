<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class registerError extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'nom' => 'required',
            'prenom' => 'required',
            'password' => 'required|min:7',
        ];
    }


        public function messages(): array

{

    return [

        'nom.required' => 'Le nom est obligatoire',
        'password.min' => 'Au moins 7 caracteres',
        'prenom.required' => 'Le prenom est obligatoire',
        'email.required' => "l'email est obligatoire",
       
    ];

}
}
