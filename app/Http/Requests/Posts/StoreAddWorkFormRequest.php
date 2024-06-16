<?php

namespace App\Http\Requests\Posts;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddWorkFormRequest extends FormRequest
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
            'provider_id' => ['required', 'exists:providers,id'],
            'description' => ['nullable', 'string'],
            'post_images' => 'nullable|array|max:5', // Allow an array of up to 5 images
            'post_images.*' => 'image|max:2048',

        ];
    }
}
