<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NetworkRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'addresses_mask' => [
                'required_if:addresses.*.name,""',
                'string',
                'max:255',
                'regex:/[0-9+-]/',
            ],
            'addresses' => [

                'array'
            ],
            'addresses.*.name' => [
                Rule::requiredIf(function () {
                    return $this->input('addresses.0.name', false);
                }),
                Rule::when($this->input('addresses.0.name', false), 'string'),
                Rule::when($this->input('addresses.0.name', false), 'ip'),
            ],
            'addresses.*.frozen' => ['sometimes', 'bool'],
        ];
    }
}
