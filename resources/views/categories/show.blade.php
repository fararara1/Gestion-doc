@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title"><i class="bi bi-tags"></i> Détail de la catégorie</h1>
        <p class="page-subtitle">Informations</p>
    </div>
    <div>
        <a href="{{ route('categories.edit', $category) }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-pencil"></i> Modifier
        </a>
        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h4 class="font-display text-navy-900" style="margin-bottom: 12px;">{{ $category->nom }}</h4>

        <div class="mt-4">
            <strong class="text-navy-600">Documents associés :</strong>
            <span class="badge bg-primary ms-2">{{ $category->documents_count }}</span>
        </div>
    </div>
</div>
@endsection
