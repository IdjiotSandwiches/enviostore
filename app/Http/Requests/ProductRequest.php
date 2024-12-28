<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name_en' => 'required|string|max:255',
            'name_id' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_id' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stocks' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id', 
            'sustainability_score' => 'required|float|between:0,5',
        ];
    }
}
