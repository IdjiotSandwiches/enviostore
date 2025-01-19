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
            'name_en' => 'nullable|string|max:255',
            'name_id' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
            'description_id' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'stocks' => 'nullable|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'sustainability_score' => 'nullable|numeric|between:0,100',
            'product_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
