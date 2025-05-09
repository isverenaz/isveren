<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'name.az' => 'required|max:255',
            'address.az' => 'required',
            'description.az' => 'required',
            'logo' => 'file|mimes:jpeg,jpg,png,gif|max:2048',
            'contract' => 'file|mimes:pdf,docx|max:500000',
        ];
    }

}
