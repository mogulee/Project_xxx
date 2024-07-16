<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;


class OrderRequest extends FormRequest
{
    public function authorize(): true
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'string',
            'name' => [
                'required',
                'string',
                'regex:/^([A-Z][a-z]*\s*)*$/',
                'regex:/^[A-Za-z\s]*$/',
            ],
            'address'=>'array',
            'price' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    if ($this->input('currency') === 'USD') {
                        $value *= 31;
                    }
                    if ($value > 2000) {
                        $fail('Price is over 2000.');
                    }
                },
            ],
            'currency' => [
                'required',
                Rule::in(['TWD', 'USD']),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => [
                '/^([A-Z][a-z]*\s*)*$/' => 'Name is not capitalized',
                '/^[A-Za-z]*$/' => 'Name contains non-English characters',
            ],
            'price.numeric' => 'Price is over 2000',
            'currency.in' => ' Currency format is wrong',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
//    protected function failedValidation(Validator $validator)
//    {
//        throw new ValidationException($validator, response()->json($validator->errors(), 400));
//    }

}
