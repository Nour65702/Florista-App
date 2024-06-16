<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'collection_id' => 'required|exists:collections,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'size' => 'array',
            'size.*' => 'string|max:255',
            'rate' => 'nullable|integer|min:0|max:5',
            'min_level' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'in_stock' => 'boolean',
            'on_sale' => 'boolean',
            'additions' => 'array|exists:additions,id',
            'image' => 'required|image|mimes:png,jpg,jpeg,webp'
        ];
    }
}
