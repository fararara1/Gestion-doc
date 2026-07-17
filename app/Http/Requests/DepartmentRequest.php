<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $departmentId = $this->route('department')?->id;

        return [
            'nom' => ['required', 'string', 'max:255', Rule::unique('departments', 'nom')->ignore($departmentId)],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom du département est obligatoire.',
            'nom.unique' => 'Ce département existe déjà.',
        ];
    }
}