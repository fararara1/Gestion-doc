<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMeetingRequest extends FormRequest
{
    public function authorize(): bool
    {
        $meeting = $this->route('meeting');

        // Seul l'organisateur (créateur) ou un administrateur peut modifier
        return $this->user()?->isAdmin() || $this->user()->id === $meeting->user_id;
    }

    public function rules(): array
    {
        return [
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'date' => ['required', 'date'],
            'heure_debut' => ['required', 'date_format:H:i'],
            'heure_fin' => ['required', 'date_format:H:i', 'after:heure_debut'],
            'participant_ids' => ['required', 'array', 'min:1'],
            'participant_ids.*' => ['exists:users,id'],
            'document_ids' => ['nullable', 'array'],
            'document_ids.*' => ['exists:documents,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre est obligatoire.',
            'date.required' => 'La date est obligatoire.',
            'heure_debut.required' => 'L\'heure de début est obligatoire.',
            'heure_fin.required' => 'L\'heure de fin est obligatoire.',
            'heure_fin.after' => 'L\'heure de fin doit être après l\'heure de début.',
            'participant_ids.required' => 'Sélectionnez au moins un participant.',
        ];
    }
}