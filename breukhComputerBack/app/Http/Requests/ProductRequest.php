<?php

namespace App\Http\Requests;

use App\Traits\HttpResp;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class ProductRequest extends FormRequest
{
    use HttpResp;
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "libelle" => 'required|string|min:3',
            'code' => 'required | string',
            'reduction' => 'number',
            'image' => 'required',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->error(500, "Quelque chose s'est mal passé", $validator->errors(),)
        );
    }

    public function messages()
    {
        return [
            'libelle.required' => 'Le libelle est obligatoire',
            'libelle.string' => 'le libelle doit etre de type chaine de caractères',
            'libelle.unique' => 'Le libelle doit etre unique',
            'libelle.min' => 'Le libelle doit etre composé de minimum de trois caractere',
        ];
    }
}
