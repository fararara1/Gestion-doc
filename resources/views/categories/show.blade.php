@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-tags"></i> Détail de la catégorie</h2>
    <div>
        <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Modifier
        </a>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-3">{{ $category->nom }}</h4>

        <div class="mt-4">
            <strong>Documents associés :</strong>
            <span class="badge bg-info">{{ $category->documents_count }}</span>
        </div>
    </div>
</div>
@endsection
