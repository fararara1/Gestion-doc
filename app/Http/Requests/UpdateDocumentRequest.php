<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $document = $this->route('document');

        // Seul l'auteur ou un administrateur peut modifier le document
        return $this->user()?->isAdmin() || $this->user()->id === $document->user_id;
    }

    public function rules(): array
    {
        return [
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'fichier' => ['nullable', 'file', 'max:10240'], // optionnel : remplace le fichier existant
            'project_id' => ['required', 'exists:projects,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'department_id' => ['required', 'exists:departments,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre est obligatoire.',
            'fichier.max' => 'Le fichier ne doit pas dépasser 10 Mo.',
            'project_id.required' => 'Le projet est obligatoire.',
            'category_id.required' => 'La catégorie est obligatoire.',
            'department_id.required' => 'Le département est obligatoire.',
        ];
    }
}