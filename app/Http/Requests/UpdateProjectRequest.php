<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $projectId = $this->route('project')?->id;

        return [
            'nom' => ['required', 'string', 'max:255', Rule::unique('projects', 'nom')->ignore($projectId)],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom du projet est obligatoire.',
            'nom.unique' => 'Ce projet existe déjà.',
        ];
    }
}