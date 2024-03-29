<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskStatusRequest extends FormRequest
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
            'name' => 'required|unique:task_statuses',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('validation.custom_required_field_error'),
            'name.unique' => __('validation.custom_unique_task_status_error'),
        ];
    }
}
