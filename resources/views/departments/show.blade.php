@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title"><i class="bi bi-building"></i> Détail du département</h1>
        <p class="page-subtitle">Informations et équipe</p>
    </div>
    <div>
        <a href="{{ route('departments.edit', $department) }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-pencil"></i> Modifier
        </a>
        <a href="{{ route('departments.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <h4 class="font-display text-navy-900" style="margin-bottom: 8px;">{{ $department->nom }}</h4>
        <p class="text-navy-600 mb-0">{{ $department->description ?: 'Aucune description.' }}</p>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-people"></i></div>
            <p class="stat-value">{{ $department->users->count() }}</p>
            <p class="stat-label">Utilisateurs</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-file-earmark-text"></i></div>
            <p class="stat-value">{{ $department->documents->count() }}</p>
            <p class="stat-label">Documents</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-kanban"></i></div>
            <p class="stat-value">{{ $department->projects->count() }}</p>
            <p class="stat-label">Projets</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header">
                <i class="bi bi-people"></i> Utilisateurs du département
            </div>
            <div class="card-body">
                @forelse($department->users as $user)
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                        <div>
                            {{ $user->prenom }} {{ $user->nom }}
                            <span class="badge {{ $user->isAdmin() ? 'bg-primary' : 'bg-light' }}">
                                {{ $user->isAdmin() ? 'Admin' : 'Collaborateur' }}
                            </span>
                        </div>
                        <small class="text-navy-600">{{ $user->email }}</small>
                    </div>
                @empty
                    <p class="text-navy-600 mb-0">Aucun utilisateur dans ce département.</p>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-file-earmark-text"></i> Documents du département
            </div>
            <div class="card-body">
                @forelse($department->documents as $document)
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                        <div>
                            <a href="{{ route('documents.show', $document) }}" class="text-navy-900 text-decoration-none fw-semibold">{{ $document->titre }}</a>
                        </div>
                        <small class="text-navy-600">{{ $document->created_at->format('d/m/Y') }}</small>
                    </div>
                @empty
                    <p class="text-navy-600 mb-0">Aucun document dans ce département.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
