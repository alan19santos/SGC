<?php


namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUpdateRevenueExpenseFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'type' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'description' => 'nullable|string',
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
