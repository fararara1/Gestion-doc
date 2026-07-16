<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShareDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $document = $this->route('document');

        // Seul l'auteur du document ou un administrateur peut le partager
        return $this->user()?->isAdmin() || $this->user()->id === $document->user_id;
    }

    public function rules(): array
    {
        return [
            'user_ids' => ['required', 'array', 'min:1'],
            'user_ids.*' => ['exists:users,id'],
            'droit' => ['required', 'in:lecture,modification'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_ids.required' => 'Sélectionnez au moins un collaborateur.',
            'droit.required' => 'Le droit d\'accès est obligatoire.',
        ];
    }
}