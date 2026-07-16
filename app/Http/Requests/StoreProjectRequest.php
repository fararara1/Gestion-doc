<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'max:255', 'unique:projects,nom'],
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