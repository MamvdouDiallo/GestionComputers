<?php

namespace App\Http\Requests;

use App\Traits\HttpResp;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class CommandeRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id'=>'required | datetime',
            'reduction'=>'sometimes | numeric',
            'utilisateur_id'=>'required|integer|exists:ulisateurs,id' ,
            'client_id'=>'required|integer|exists:clients,id'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->error(500,"Quelque chose s'est mal passé",$validator->errors(),)
        );
    }
}
