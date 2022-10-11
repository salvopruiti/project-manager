<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules\Unique;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        $user = \Route::current()->parameter('user') ?? new User();

        $passwordRules[] = $user->id ? 'nullable' : 'required';

        $passwordRules[] = Password::min(5)->letters()->symbols()->numbers()->mixedCase();
        $passwordRules[] = 'confirmed';

        return [
            'name' => 'required',
            'email' => ['required', (new Unique('users', 'email'))->ignore($user->id)],
            'password' => $passwordRules
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
