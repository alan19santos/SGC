<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class StoreUpdateResidentFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'       => 'required|max:50|string',
            'cpf'        => 'required|unique:cpf|min:3|max:11|cpf',
            'rg'         => 'required|unique:rg|min:3|max:10|rg',
            'email'      => 'required|max:80|string',
            'birth_date' => 'required',
            'condominium_id' => 'required',
            'tower_id'   => 'required',
            'apartment_id'=>'required',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $response = response()->json([
            "error" => "Erro no envio de dados.",
            "details" => $errors->messages()
        ], 422);
        throw new HttpResponseException($response);
    }
}
