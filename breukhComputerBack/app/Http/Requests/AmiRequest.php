<?php

namespace App\Http\Requests;

use App\Traits\HttpResp;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class AmiRequest extends FormRequest
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
    public function rules()
    {
        return [
            'succursale1_id' => [
                'required',
                'exists:succursales,id',
                Rule::unique('amis')->where(function ($query) {
                    return $query->where('succursale2_id', $this->input('succursale2_id'));
                }),
                function ($value, $fail) {
                    $succursale2_id = $this->input('succursale2_id');
                    if ($value == $succursale2_id) {
                        $fail("Les IDs des succursales doivent être différents.");
                    }
                },
            ],
            'succursale2_id' => [
                'required',
                'exists:succursales,id',
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->error(500, "Quelque chose s'est mal passé", $validator->errors(),)
        );
    }
}
