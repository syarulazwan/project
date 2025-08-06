<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            'code_update' => 'required',
            'name_update' => 'required',
            'status_update' => 'required',
            'start_date_update' => 'required',
            'end_date_update' => 'required',
        ];

    }

    public function messages(){
        return [
            'code_update.required' => 'Field Required',
            'name_update.required' => 'Field Required',
            'status_update.required' => 'Field Required',
            'start_date_update.required' => 'Field Required',
            'end_date_update.required' => 'Field Required',
        ];
    }
}
