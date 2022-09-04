<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required | max:20',
            'tag' => 'required | max:15',
            'body' => 'required | max:25',
            'image' => 'required'

            // 'required|max:1024|mimes:jpg,jpeg,png,gif'
        ];
    }
}
