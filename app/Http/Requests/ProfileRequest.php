<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'string',
            'phone_number' => 'regex:/^(?:0|\+62)[0-9]{8,12}$/',  
            'address' => 'string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'confirmed|min:8',
            'password_confirm' => 'required',
        ];
    }
}
