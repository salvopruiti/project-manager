<?php

namespace App\Http\Requests;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;

class CompanyRequest extends FormRequest
{
    public function rules(): array
    {
        $company = \Route::current()->parameter('company') ?? new Company();

        return [
            'name' => ['required', (new Unique('companies', 'name'))->ignore($company->id)]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
