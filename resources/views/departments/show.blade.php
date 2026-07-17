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
    <h2><i class="bi bi-building"></i> Détail du département</h2>
    <div>
        <a href="{{ route('departments.edit', $department) }}" class="btn-gold-sm">
            <i class="bi bi-pencil"></i> Modifier
        </a>
        <a href="{{ route('departments.index') }}" class="btn-outline-gold">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="detail-card mb-3">
    <div class="card-body">
        <h4 style="font-family: 'Playfair Display', serif; color: var(--navy-900); margin-bottom: 8px;">{{ $department->nom }}</h4>
        <p style="color: var(--navy-600); margin: 0;">{{ $department->description ?: 'Aucune description.' }}</p>
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
        <div class="detail-card mb-3">
            <div class="card-header">
                <i class="bi bi-people"></i> Utilisateurs du département
            </div>
            <div class="card-body">
                @forelse($department->users as $user)
                    <div class="list-item">
                        <div>
                            {{ $user->prenom }} {{ $user->nom }}
                            <span class="{{ $user->isAdmin() ? 'badge-gold' : '' }}" @if(!$user->isAdmin()) style="background: #f1f5f9; color: var(--navy-600); font-weight: 600; padding: 0.4em 0.9em; border-radius: 50px; font-size: 0.72rem; text-transform: uppercase;" @endif>
                                {{ $user->isAdmin() ? 'Admin' : 'Collaborateur' }}
                            </span>
                        </div>
                        <small style="color: var(--navy-600);">{{ $user->email }}</small>
                    </div>
                @empty
                    <p style="color: var(--navy-600); margin: 0;">Aucun utilisateur dans ce département.</p>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="detail-card">
            <div class="card-header">
                <i class="bi bi-file-earmark-text"></i> Documents du département
            </div>
            <div class="card-body">
                @forelse($department->documents as $document)
                    <div class="list-item">
                        <div>
                            <a href="{{ route('documents.show', $document) }}">{{ $document->titre }}</a>
                        </div>
                        <small style="color: var(--navy-600);">{{ $document->created_at->format('d/m/Y') }}</small>
                    </div>
                @empty
                    <p style="color: var(--navy-600); margin: 0;">Aucun document dans ce département.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
