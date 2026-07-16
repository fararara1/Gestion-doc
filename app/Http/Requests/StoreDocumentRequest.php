<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Tout utilisateur connecté peut ajouter un document
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'fichier' => ['required', 'file', 'max:10240'], // 10 Mo max
            'project_id' => ['required', 'exists:projects,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'department_id' => ['required', 'exists:departments,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre est obligatoire.',
            'fichier.required' => 'Le fichier est obligatoire.',
            'fichier.max' => 'Le fichier ne doit pas dépasser 10 Mo.',
            'project_id.required' => 'Le projet est obligatoire.',
            'category_id.required' => 'La catégorie est obligatoire.',
            'department_id.required' => 'Le département est obligatoire.',
        ];
    }
}