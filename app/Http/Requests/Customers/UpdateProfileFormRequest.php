<?php

namespace App\Http\Requests\Customers;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileFormRequest extends FormRequest
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
        $userId = $this->route('customer');
        return [
            'name' => 'nullable|max:50|unique:providers,name,' . $userId,
            'email' => 'nullable|email|unique:providers,email,' . $userId,
            'phone' => 'nullable|numeric|unique:providers,phone,' . $userId,
            'password' => 'nullable|min:6|confirmed',
            'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
