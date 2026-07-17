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
            'date_debut' => ['nullable', 'date'],
            'date_fin' => ['nullable', 'date', 'after_or_equal:date_debut'],
            'statut' => ['nullable', 'in:En attente,En cours,Terminé'],
            'department_id' => ['nullable', 'exists:departments,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom du projet est obligatoire.',
            'nom.unique' => 'Ce projet existe déjà.',
            'date_fin.after_or_equal' => 'La date de fin doit être postérieure ou égale à la date de début.',
        ];
    }
}