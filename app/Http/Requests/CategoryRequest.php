<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;

class CategoryRequest extends FormRequest
{
    public function rules(): array
    {
        $category = \Route::current()->parameter('category') ?? new Category();

        return [
            'name' => ['required', (new Unique('categories', 'name'))->ignore($category->id)]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
