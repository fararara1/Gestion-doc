@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title"><i class="bi bi-kanban"></i> Détail du projet</h1>
        <p class="page-subtitle">Vue d'ensemble</p>
    </div>
    <div>
        <a href="{{ route('projects.edit', $project) }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-pencil"></i> Modifier
        </a>
        <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <h4 class="font-display text-navy-900" style="margin-bottom: 8px;">{{ $project->nom }}</h4>
        <p class="text-navy-600 mb-0">{{ $project->description ?: 'Aucune description.' }}</p>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-calendar-event"></i></div>
            <p class="stat-value" style="font-size: 1.1rem;">{{ $project->date_debut ? $project->date_debut->format('d/m/Y') : 'Non définie' }}</p>
            <p class="stat-label">Date de début</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-calendar-check"></i></div>
            <p class="stat-value" style="font-size: 1.1rem;">{{ $project->date_fin ? $project->date_fin->format('d/m/Y') : 'Non définie' }}</p>
            <p class="stat-label">Date de fin</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-flag"></i></div>
            <p class="stat-value" style="font-size: 1.1rem;">
                @php
                    $statutClass = match($project->statut) {
                        'En cours' => 'bg-primary',
                        'Terminé' => 'bg-success',
                        default => 'bg-warning',
                    };
                @endphp
                <span class="badge {{ $statutClass }}">{{ $project->statut }}</span>
            </p>
            <p class="stat-label">Statut</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-building"></i></div>
            <p class="stat-value" style="font-size: 1.1rem;">{{ $project->department?->nom ?? 'Aucun' }}</p>
            <p class="stat-label">Département</p>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <i class="bi bi-file-earmark-text"></i> Documents associés
        <span class="badge bg-primary ms-2">{{ $project->documents_count }}</span>
    </div>
    <div class="card-body">
        @forelse($project->documents as $document)
            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                <div>
                    <a href="{{ route('documents.show', $document) }}" class="text-navy-900 text-decoration-none fw-semibold">{{ $document->titre }}</a>
                    <span class="badge bg-primary ms-2">{{ $document->category?->nom ?? '—' }}</span>
                </div>
            </div>
        @empty
            <p class="text-navy-600 mb-0">Aucun document associé.</p>
        @endforelse
    </div>
</div>
@endsection
