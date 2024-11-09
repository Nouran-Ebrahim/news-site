<?php

namespace App\Http\Requests;

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
            'site_name' => 'required|string|min:2|max:50',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'logo' => 'nullable|image|mimes:png,jpg',
            'favicon' => 'nullable|image|mimes:png,jpg',
            'country' => 'required|min:2|max:100',
            'city' => 'required|min:2|max:100',
            'street' => 'required|min:2|max:100',
            'facebook' => 'required|url',
            'twitter' => 'required|url',
            'instgram' => 'required|url',
            'youtube' => 'required|url',
            'small_desc' => 'required|min:2',

        ];
    }
}
