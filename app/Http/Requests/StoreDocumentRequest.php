<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'fichier' => ['required', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,jpg,jpeg,png', 'max:' . config('document.max_file_size', 10240)],
            'project_id' => ['required', 'exists:projects,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'department_id' => ['required', 'exists:departments,id'],
        ];
    }

    public function messages(): array
    {
        $maxSize = config('document.max_file_size', 10240) / 1024;

        return [
            'titre.required' => 'Le titre est obligatoire.',
            'titre.max' => 'Le titre ne doit pas dépasser 255 caractères.',
            'description.max' => 'La description ne doit pas dépasser 5000 caractères.',
            'fichier.required' => 'Le fichier est obligatoire.',
            'fichier.mimes' => 'Le fichier doit être de type : PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, JPG, JPEG ou PNG.',
            'fichier.max' => "Le fichier ne doit pas dépasser {$maxSize} Mo.",
            'project_id.required' => 'Le projet est obligatoire.',
            'category_id.required' => 'La catégorie est obligatoire.',
            'department_id.required' => 'Le département est obligatoire.',
        ];
    }
}
