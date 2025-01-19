<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditProductRequest extends FormRequest
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
            'name_en' => 'required|string|max:255',
            'description_en' => 'required|string|max:500',
            'description_id' => 'required|string|max:500',
            'price' => 'required|numeric|min:0',
            'stocks' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'sustainability_score' => 'nullable|numeric|min:0|max:5',
            'product_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'integer|exists:product_images,id',
        ];
    }
}
