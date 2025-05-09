<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class UserRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:50',
            'surname' => 'required',
            'email' => 'email',
//            'password' => 'min:6|required_with:confirm_password|same:confirm_password',
//            'confirm_password' => 'min:6'
        ];
    }

    public function messages(): array
    {
        return [
            '*.required' => Lang::get('validation.required', ['attribute' => ':attribute']),
            '*.max' => Lang::get('validation.max', ['attribute' => ':attribute']),
        ];
    }
}
