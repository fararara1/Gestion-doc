@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-kanban"></i> Détail du projet</h2>
    <div>
        <a href="{{ route('projects.edit', $project) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Modifier
        </a>
        <a href="{{ route('projects.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-3">{{ $project->nom }}</h4>

        @if($project->description)
            <p class="text-muted">{{ $project->description }}</p>
        @endif

        <hr>

        <div class="row mt-3">
            <div class="col-md-6">
                <strong>Date de début :</strong>
                <p class="text-muted">{{ $project->date_debut ? \Carbon\Carbon::parse($project->date_debut)->format('d/m/Y') : 'Non définie' }}</p>
            </div>
            <div class="col-md-6">
                <strong>Date de fin :</strong>
                <p class="text-muted">{{ $project->date_fin ? \Carbon\Carbon::parse($project->date_fin)->format('d/m/Y') : 'Non définie' }}</p>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <strong>Statut :</strong>
                @php
                    $statutClass = match($project->statut) {
                        'En cours' => 'bg-success',
                        'Terminé' => 'bg-primary',
                        default => 'bg-warning',
                    };
                @endphp
                <span class="badge {{ $statutClass }}">{{ $project->statut }}</span>
            </div>
            <div class="col-md-6">
                <strong>Département :</strong>
                <p class="text-muted">{{ $project->department?->nom ?? 'Aucun' }}</p>
            </div>
        </div>

        <div class="mt-4">
            <strong>Documents associés :</strong>
            <span class="badge bg-info">{{ $project->documents_count }}</span>
        </div>
    </div>
</div>
@endsection
