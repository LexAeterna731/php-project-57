<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLabelRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|unique:labels',
            'description' => 'max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('validation.custom_required_field_error'),
            'name.unique' => __('validation.custom_unique_field_error'),
            'description.max' => __('validation.custom_max_field_error'),
        ];
    }
}
