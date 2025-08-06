<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class AddProjectRequest extends FormRequest
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
     public function rules()
    {
        return [
            'code' => 'required',
            'name' => 'required',
            'status' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ];

    }

    public function messages(){
        return [
            'code.required' => 'Field Required',
            'name.required' => 'Field Required',
            'status.required' => 'Field Required',
            'start_date.required' => 'Field Required',
            'end_date.required' => 'Field Required',
        ];
    }
}
