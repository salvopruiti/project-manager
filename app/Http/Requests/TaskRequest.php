<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required',
            'status' => '',
            'user_id' => '',
            'ticket_id' => '',
            'category_id' => '',
            'customer_id' => '',
            'description' => '',
            'priority' => '',
            'estimated_time' => '',
            'tags' => 'array'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
