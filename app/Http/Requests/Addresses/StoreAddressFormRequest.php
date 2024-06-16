<?php

namespace App\Http\Requests\Addresses;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressFormRequest extends FormRequest
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
            'user_id' => ['nullable', 'exists:users,id'],
            'order_id' => ['nullable', 'exists:orders,id'],
            'city' => ['required', 'string', 'max:255'],
            'country_id' => ['required', 'exists:countries,id'],
            'line_one' => ['required', 'string', 'max:255'],
            'line_two' => ['nullable', 'string', 'max:255'],
            'street' => ['required', 'string', 'max:255'],
        ];
    }
}
