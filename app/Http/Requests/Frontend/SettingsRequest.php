<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:50',
            'username' => "required|min:2|max:50|unique:users,username," . auth()->user()->id,
            'email' => 'required|email|unique:users,email,' . auth()->user()->id,
            'phone' => 'required|numeric|unique:users,phone,' . auth()->user()->id,
            'image' => 'nullable|image|mimes:png,jpg',
            'country' => 'nullable|min:2|max:100',
            'city' => 'nullable|min:2|max:100',
            'street' => 'nullable|min:2|max:100',

        ];
    }
}
