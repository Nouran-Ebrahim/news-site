<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $user_id=$this->route('user') ;//we use that in edit
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'phone' => ['required', 'string', 'max:16', 'unique:users,phone'],
            'country' => ['nullable', 'string', 'min:2', 'max:50'],
            'city' => ['nullable', 'string', 'min:2', 'max:50'],
            'street' => ['nullable', 'string', 'min:2', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'stauts' => ['in:0,1'],
            'email_verified_at' => ['in:0,1']
        ];
    }

}
