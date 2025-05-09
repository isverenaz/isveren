<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class JobRequest extends FormRequest
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
            'title.*' => 'required',
            'description.*' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'job_type_id' => 'required',
            'city_id' => 'required',
            'company_id' => 'required',
            'max_salary' => 'required',
            'end_date' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' =>  Lang::get('validation.required', ['attribute' => ':attribute']),
        ];
    }
}
