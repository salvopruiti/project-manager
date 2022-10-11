<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Exists;

class CustomerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'company_id' => ['nullable', (new Exists('companies', 'id'))],
            'email' => ['required', 'email']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
