<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
        $rules = [
            'title' => 'required|string|min:3|max:50',
            'desc' => 'required|min:10',
            'category_id' => 'required|exists:categories,id',
            'comment_able' => 'boolean',
            'images.*' => 'image|mimes:png,jpg',
            'small_desc' => 'required|min:70|max:170',
            // 'user_id' => 'required|exists:users,id',
            'status' => 'nullable|in:1,0'

        ];
        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $rules['images'] = ['nullable'];


        }else{
            $rules['images'] = ['required'];
        }
        return $rules;
    }
    // public function messages(): array
    // {
    //     return [

    //         'category_id.required' => 'Category is required',


    //     ];
    // }

    public function prepareForValidation()
    {   //or we can put it in controller
        if ($this->comment_able == "on") {
            $this->merge([
                'comment_able' => 1,
            ]);
        } else {
            $this->merge([
                'comment_able' => 0,
            ]);
        }
        // $this->merge([
        //     'user_id' => auth()->user()->id,
        // ]);
    }
    public function attributes()
    {
        return [
            'title' => 'Post Title',
            'desc' => 'Post Description',
            'category_id' => 'Category',
            'comment_able' => 'Commentable',
            'images' => 'Post Images',
            'user_id' => 'User'
        ];
    }
}
