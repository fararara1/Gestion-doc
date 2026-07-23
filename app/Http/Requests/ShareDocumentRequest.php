<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShareDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'user_ids' => ['required', 'array', 'min:1'],
            'user_ids.*' => ['exists:users,id', 'distinct'],
            'droit' => ['required', 'in:lecture,modification'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_ids.required' => 'Sélectionnez au moins un collaborateur.',
            'user_ids.min' => 'Sélectionnez au moins un collaborateur.',
            'user_ids.*.exists' => 'Un des utilisateurs sélectionnés est invalide.',
            'user_ids.distinct' => 'Un utilisateur ne peut être sélectionné qu\'une seule fois.',
            'droit.required' => 'Le droit d\'accès est obligatoire.',
            'droit.in' => 'Le droit d\'accès sélectionné est invalide.',
        ];
    }
}
