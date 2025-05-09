<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class TranslationsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() :bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() :array
    {
        return [
            'name' => 'required|min:5|max:50',
            'code' => 'required|min:1|max:5'
        ];
    }

    public function messages():array
    {
        return [
            '*.required' => Lang::get('validation.required', ['attribute' => ':attribute']),
            '*.max' => Lang::get('validation.max', ['attribute' => ':attribute']),
            '*.min' => Lang::get('validation.min', ['attribute' => ':attribute']),
        ];
    }
}
