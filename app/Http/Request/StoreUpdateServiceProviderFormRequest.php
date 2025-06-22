<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class StoreUpdateServiceProviderFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'          => 'required|max:50|string',
            'unity_name'          => 'required|max:150|string',
            'unity_tower'    => 'required|max:50|string',
            'entry_time'              => 'required|max:50|string',
            'drive'              => 'required|max:20|string',
            'plate'              => 'required|max:10|string',
            'rg'              => 'required|max:10|string',
            'departure_time'              => 'required|max:10|string',
            'concierge_visa'              => 'required|max:10|string',
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
