<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required|unique:users,username|unique:admins,username',
            'email' => 'required|email:dns|unique:users,email|unique:admins,email',
            'phone_number' => ['required', 'regex:/^(?:0|\+62)[0-9]{8,12}$/'],
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
            'terms_and_condition' => 'accepted|required',
        ];
    }
}
