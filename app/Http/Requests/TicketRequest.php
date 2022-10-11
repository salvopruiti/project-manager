<?php

namespace App\Http\Requests;

use App\Models\Ticket;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Exists;

class TicketRequest extends FormRequest
{
    public function rules(): array
    {
        $ticket = \Route::current()->parameter('ticket') ?: new Ticket();
        $bodyRules = [];

        if(!$ticket->exists)
            $bodyRules[] = 'required';

        return [
            'customer_id' => 'required', new Exists('customers', 'id'),
            'category_id' => 'required', new Exists('categories', 'id'),
            'source' => 'required',
            'status' => 'required',
            'priority' => 'required',
            'title' => 'required',
            'body' => $bodyRules,
            'create_task' => ''
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'create_task' => request('create_task', 0)
        ]);
    }


    public function authorize(): bool
    {
        return true;
    }
}
