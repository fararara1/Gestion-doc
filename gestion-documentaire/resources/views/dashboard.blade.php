@extends('layouts.app')

@section('content')
<div class="page-header animate-fade-in-up">
    <div>
        <h1 class="page-title">Tableau de bord</h1>
        <p class="page-subtitle">Bienvenue, {{ Auth::user()->prenom }} {{ Auth::user()->nom }}. Voici un aperçu de votre espace de travail.</p>
    </div>
    <div class="d-flex gap-2">
        <span class="badge bg-primary" style="font-size: 0.75rem;">
            <i class="bi bi-shield-check"></i> {{ ucfirst(Auth::user()->role) }}
        </span>
        <a href="{{ route('documents.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Nouveau document
        </a>
        <a href="{{ route('meetings.create') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-calendar-plus"></i> Nouvelle réunion
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6 animate-fade-in-up stagger-1">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-folder2-open"></i></div>
            <div class="stat-label">Documents</div>
            <div class="stat-value">{{ $documentsCount ?? 0 }}</div>
            <span class="badge bg-primary" style="font-size: 0.75rem; margin-top: 0.75rem;">Actif</span>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 animate-fade-in-up stagger-2">
        <div class="stat-card">
            <div class="stat-icon success"><i class="bi bi-calendar-event"></i></div>
            <div class="stat-label">Réunions</div>
            <div class="stat-value">{{ $meetingsCount ?? 0 }}</div>
            <span class="badge bg-primary" style="font-size: 0.75rem; margin-top: 0.75rem;">Planifié</span>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 animate-fade-in-up stagger-3">
        <div class="stat-card">
            <div class="stat-icon warning"><i class="bi bi-kanban"></i></div>
            <div class="stat-label">Projets</div>
            <div class="stat-value">{{ $projectsCount ?? 0 }}</div>
            <span class="badge bg-warning" style="font-size: 0.75rem; margin-top: 0.75rem;">En cours</span>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 animate-fade-in-up stagger-4">
        <div class="stat-card">
            <div class="stat-icon info"><i class="bi bi-people-fill"></i></div>
            <div class="stat-label">Utilisateurs</div>
            <div class="stat-value">{{ $usersCount ?? 0 }}</div>
            <span class="badge bg-success" style="font-size: 0.75rem; margin-top: 0.75rem;">Inscrits</span>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6 animate-fade-in-up stagger-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-file-earmark-text" style="color: var(--gold-500);"></i> Documents récents</span>
                <a href="{{ route('documents.index') }}" class="btn btn-outline-primary btn-sm">Voir tout <i class="bi bi-arrow-right-short"></i></a>
            </div>
            <div class="card-body">
                @forelse($recentDocuments ?? [] as $document)
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                        <div>
                            <a href="{{ route('documents.show', $document) }}" style="color: var(--navy-900); text-decoration: none; font-weight: 600; font-size: 0.95rem;">{{ $document->titre }}</a>
                            <div style="font-size: 0.8rem; color: var(--navy-600); margin-top: 2px;">
                                {{ $document->user?->prenom }} {{ $document->user?->nom }} • {{ $document->created_at->format('d/m/Y') }}
                            </div>
                        </div>
                        <a href="{{ route('documents.download', $document) }}" class="btn btn-sm btn-success btn-icon" title="Télécharger">
                            <i class="bi bi-download"></i>
                        </a>
                    </div>
                @empty
                    <div class="text-center py-4" style="color: var(--navy-600);">
                        <i class="bi bi-inbox" style="font-size: 2rem; color: var(--gold-400); margin-bottom: 0.5rem; display: block;"></i>
                        <p style="margin: 0; font-size: 0.9rem; font-weight: 500;">Aucun document disponible.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-6 animate-fade-in-up stagger-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-calendar-check" style="color: var(--gold-500);"></i> Prochaines réunions</span>
                <a href="{{ route('meetings.index') }}" class="btn btn-outline-primary btn-sm">Voir tout <i class="bi bi-arrow-right-short"></i></a>
            </div>
            <div class="card-body">
                @forelse($upcomingMeetings ?? [] as $meeting)
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                        <div>
                            <a href="{{ route('meetings.show', $meeting) }}" style="color: var(--navy-900); text-decoration: none; font-weight: 600; font-size: 0.95rem;">{{ $meeting->titre }}</a>
                            <div style="font-size: 0.8rem; color: var(--navy-600); margin-top: 2px;">
                                <i class="bi bi-calendar"></i> {{ \Carbon\Carbon::parse($meeting->date)->format('d/m/Y') }}
                                <span class="mx-1">•</span>
                                <i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($meeting->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($meeting->heure_fin)->format('H:i') }}
                            </div>
                            <div style="font-size: 0.8rem; color: var(--navy-600); margin-top: 2px;">
                                <i class="bi bi-people"></i> {{ $meeting->participants->count() }} participant(s)
                            </div>
                        </div>
                        <a href="{{ route('meetings.ics', $meeting) }}" class="btn btn-sm btn-outline-secondary btn-icon" title="Télécharger ICS">
                            <i class="bi bi-calendar-event"></i>
                        </a>
                    </div>
                @empty
                    <div class="text-center py-4" style="color: var(--navy-600);">
                        <i class="bi bi-calendar-x" style="font-size: 2rem; color: var(--gold-400); margin-bottom: 0.5rem; display: block;"></i>
                        <p style="margin: 0; font-size: 0.9rem; font-weight: 500;">Aucune réunion programmée.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
