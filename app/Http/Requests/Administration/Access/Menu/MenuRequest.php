<?php

namespace App\Http\Requests\Administration\Access\Menu;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
            'name' => 'required',
            'code' => 'required',
            'url' => 'required',
            // 'route' => 'required',
            'icon' => 'required',
            'priority' => 'required',
        ];
    }

    public function messages(){
        return [
            'name.required'=> 'Field Required',
            'code.required'=> 'Field Required',
            'url.required'=> 'Field Required',
            // 'route.required'=> 'Field Required',
            'icon.required'=> 'Field Required',
            'priority.required'=> 'Field Required',
        ];
    }
}
