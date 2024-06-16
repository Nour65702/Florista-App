<?php

namespace App\Http\Requests\Providers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

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
        $providerId = $this->route('provider'); // Assuming your route parameter name is 'provider'

        return [
            'name' => 'nullable|max:50|unique:providers,name,' . $providerId,
            'email' => 'nullable|email|unique:providers,email,' . $providerId,
            'phone' => 'nullable|numeric|unique:providers,phone,' . $providerId,
            'password' => 'nullable|min:6|confirmed',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
