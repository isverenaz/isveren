<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class PermissionRequest extends FormRequest
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
            'name' => 'required|max:50',
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
