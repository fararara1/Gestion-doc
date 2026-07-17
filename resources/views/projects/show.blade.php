@extends('layouts.app')

@section('content')
<style>
    .page-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .page-header-custom h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--navy-900);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-header-custom h2 i {
        color: var(--gold-500);
    }

    .btn-gold-sm {
        background: linear-gradient(135deg, var(--gold-500) 0%, var(--gold-400) 100%);
        color: var(--navy-900);
        border: none;
        border-radius: var(--radius-sm);
        padding: 10px 20px;
        font-weight: 700;
        font-size: 0.9rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-gold-sm:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(234, 179, 8, 0.25);
        color: var(--navy-900);
    }

    .btn-outline-gold {
        border: 1.5px solid var(--gold-400) !important;
        color: var(--gold-700) !important;
        border-radius: var(--radius-sm) !important;
        font-weight: 600;
        padding: 10px 20px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-outline-gold:hover {
        background: var(--gold-500) !important;
        color: var(--navy-900) !important;
        border-color: var(--gold-500) !important;
    }

    .detail-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    .detail-card .card-body {
        padding: 24px;
    }

    .detail-card .card-header {
        background: #ffffff;
        border-bottom: 1px solid #f1f5f9;
        padding: 16px 24px;
        font-weight: 600;
        color: var(--navy-900);
    }

    .detail-card .card-header i {
        color: var(--gold-500);
    }

    .stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-sm);
        text-align: center;
        padding: 24px;
    }

    .stat-card .stat-icon {
        font-size: 2rem;
        color: var(--gold-500);
        margin-bottom: 8px;
    }

    .stat-card .stat-value {
        font-family: 'Playfair Display', serif;
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--navy-900);
        margin: 0;
    }

    .stat-card .stat-label {
        color: var(--navy-600);
        font-size: 0.85rem;
        margin: 0;
    }

    .badge-gold {
        background: linear-gradient(135deg, var(--gold-500) 0%, var(--gold-400) 100%);
        color: var(--navy-900);
        font-weight: 700;
        padding: 0.4em 0.9em;
        border-radius: 50px;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .list-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .list-item:last-child {
        border-bottom: none;
    }

    .list-item a {
        color: var(--navy-900);
        font-weight: 600;
        text-decoration: none;
    }

    .list-item a:hover {
        color: var(--gold-700);
    }
</style>

<div class="page-header-custom">
    <h2><i class="bi bi-kanban"></i> Détail du projet</h2>
    <div>
        <a href="{{ route('projects.edit', $project) }}" class="btn-gold-sm">
            <i class="bi bi-pencil"></i> Modifier
        </a>
        <a href="{{ route('projects.index') }}" class="btn-outline-gold">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="detail-card mb-3">
    <div class="card-body">
        <h4 style="font-family: 'Playfair Display', serif; color: var(--navy-900); margin-bottom: 8px;">{{ $project->nom }}</h4>
        <p style="color: var(--navy-600); margin: 0;">{{ $project->description ?: 'Aucune description.' }}</p>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-calendar-event"></i></div>
            <p class="stat-value" style="font-size: 1.1rem;">{{ $project->date_debut ? \Carbon\Carbon::parse($project->date_debut)->format('d/m/Y') : 'Non définie' }}</p>
            <p class="stat-label">Date de début</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-calendar-check"></i></div>
            <p class="stat-value" style="font-size: 1.1rem;">{{ $project->date_fin ? \Carbon\Carbon::parse($project->date_fin)->format('d/m/Y') : 'Non définie' }}</p>
            <p class="stat-label">Date de fin</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-flag"></i></div>
            <p class="stat-value" style="font-size: 1.1rem;">
                @php
                    $statutColor = match($project->statut) {
                        'En cours' => 'var(--gold-700)',
                        'Terminé' => '#16a34a',
                        default => '#d97706',
                    };
                @endphp
                <span style="color: {{ $statutColor }}; font-size: 1rem; font-weight: 700;">{{ $project->statut }}</span>
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

<div class="detail-card mb-3">
    <div class="card-header">
        <i class="bi bi-file-earmark-text"></i> Documents associés
        <span class="badge-gold ms-2">{{ $project->documents_count }}</span>
    </div>
    <div class="card-body">
        @forelse($project->documents as $document)
            <div class="list-item">
                <div>
                    <a href="{{ route('documents.show', $document) }}">{{ $document->titre }}</a>
                    <span class="badge-gold ms-2">{{ $document->category?->nom ?? '—' }}</span>
                </div>
            </div>
        @empty
            <p style="color: var(--navy-600); margin: 0;">Aucun document associé.</p>
        @endforelse
    </div>
</div>
@endsection
