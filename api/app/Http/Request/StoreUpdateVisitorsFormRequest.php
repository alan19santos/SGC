<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class StoreUpdateVisitorsFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'       => 'required|max:50|string',
            'date'        => 'required|unique:cpf|min:3|max:11|cpf',
            'tower'         => 'required|unique:rg|min:3|max:10|rg',
            'rg'      => 'required|max:80|string',
            'entry_time' => 'required',
            'condominium_id' => 'required',
            'concierge_visa'   => 'required',
            'observation'=>'required',
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