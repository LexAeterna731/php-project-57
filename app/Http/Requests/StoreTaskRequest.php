<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'name' => 'required|unique:tasks',
            'description' => 'max:1000',
            'status_id' => 'required',
            'assigned_to_id' => 'nullable',
            'labels' => '',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('validation.custom_required_field_error'),
            'name.unique' => __('validation.custom_unique_task_error'),
            'description.max' => __('validation.custom_max_field_error'),
            'status_id.required' => __('validation.custom_required_field_error'),
        ];
    }
}
