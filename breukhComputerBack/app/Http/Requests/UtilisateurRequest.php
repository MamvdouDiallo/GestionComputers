<?php

namespace App\Http\Requests;

use App\Traits\HttpResp;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class UtilisateurRequest extends FormRequest
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
            'nom' => 'required | string |min:2',
            'prenom' => 'required | string',
            'login' => 'required|unique:utilisateurs| string',
            'password' => 'required | string| numeric |min:2',
            'poste' => 'required | string ',
            'telephone' => 'required |unique:utilisateurs| regex:/^7[5678]\d{7}$/',
            'succursale_id' => 'required|integer|exists:succursales,id'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->error(500,"Quelque chose s'est mal passé",$validator->errors(),)
        );
    }
}
