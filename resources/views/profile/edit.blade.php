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

    .profile-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    .profile-card .card-body {
        padding: 28px;
    }

    .profile-avatar {
        width: 96px;
        height: 96px;
        border-radius: var(--radius-lg);
        background: linear-gradient(135deg, var(--gold-500) 0%, var(--gold-400) 100%);
        color: var(--navy-900);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 16px;
        box-shadow: 0 8px 20px rgba(234, 179, 8, 0.2);
    }

    .profile-name {
        font-family: 'Playfair Display', serif;
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--navy-900);
        margin: 0;
    }

    .profile-role {
        display: inline-block;
        background: linear-gradient(135deg, var(--gold-500) 0%, var(--gold-400) 100%);
        color: var(--navy-900);
        font-size: 0.72rem;
        font-weight: 700;
        padding: 0.4em 1.1em;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        margin-top: 8px;
    }

    .profile-email {
        color: var(--navy-600);
        font-size: 0.9rem;
        margin-top: 8px;
    }

    .profile-dept {
        color: var(--gold-700);
        font-size: 0.88rem;
        font-weight: 600;
        text-decoration: none;
        margin-top: 4px;
        display: inline-block;
    }

    .profile-dept:hover {
        color: var(--gold-600);
    }

    .stat-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .stat-row:last-child {
        border-bottom: none;
    }

    .stat-row span:first-child {
        color: var(--navy-600);
        font-size: 0.9rem;
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

    .form-label {
        font-weight: 600;
        font-size: 13px;
        color: var(--navy-700);
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: var(--radius-sm);
        border: 1px solid #e2e8f0;
        padding: 10px 14px;
        font-size: 14px;
        transition: var(--transition);
        background: #ffffff;
        font-family: 'Inter', sans-serif;
    }

    .form-control:focus {
        border-color: var(--gold-500);
        box-shadow: 0 0 0 3px rgba(234, 179, 8, 0.06);
        outline: none;
    }

    .alert {
        border: none;
        border-radius: var(--radius-sm);
        padding: 14px 20px;
        box-shadow: var(--shadow-sm);
        border-left: 4px solid transparent;
        font-size: 14px;
    }

    .alert-success {
        background: #fefce8;
        border-left-color: var(--gold-500);
        color: var(--gold-700);
    }

    .danger-zone {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: var(--radius-xl);
        overflow: hidden;
    }

    .danger-zone .card-header {
        background: #dc2626;
        color: #ffffff;
        border-bottom: none;
        padding: 16px 24px;
        font-weight: 600;
    }

    .danger-zone .card-body {
        padding: 20px 24px;
    }
</style>

<div class="page-header-custom">
    <h2><i class="bi bi-person-circle"></i> Mon profil</h2>
</div>

<div class="row g-4">
    <!-- Colonne gauche -->
    <div class="col-lg-4">
        <div class="profile-card mb-3">
            <div class="card-body text-center">
                <div class="profile-avatar">
                    {{ strtoupper(mb_substr($user->prenom, 0, 1) . mb_substr($user->nom, 0, 1)) }}
                </div>
                <h4 class="profile-name">{{ $user->prenom }} {{ $user->nom }}</h4>
                <span class="profile-role">{{ $user->isAdmin() ? 'Administrateur' : 'Collaborateur' }}</span>
                <p class="profile-email">{{ $user->email }}</p>
                @if($user->department)
                    <a href="{{ route('departments.show', $user->department) }}" class="profile-dept">
                        <i class="bi bi-building"></i> {{ $user->department->nom }}
                    </a>
                @endif
            </div>
        </div>

        <div class="profile-card mb-3">
            <div class="card-header" style="background: #ffffff; border-bottom: 1px solid #f1f5f9; padding: 16px 24px; font-weight: 600; color: var(--navy-900);">
                Statistiques
            </div>
            <div class="card-body">
                <div class="stat-row">
                    <span>Documents créés</span>
                    <span class="badge-gold">{{ $user->documents->count() }}</span>
                </div>
                <div class="stat-row">
                    <span>Documents partagés</span>
                    <span class="badge-gold">{{ $user->sharedDocuments->count() }}</span>
                </div>
                <div class="stat-row">
                    <span>Réunions</span>
                    <span class="badge-gold">{{ $user->meetings->count() }}</span>
                </div>
            </div>
        </div>

        <div class="profile-card">
            <div class="card-header" style="background: #ffffff; border-bottom: 1px solid #f1f5f9; padding: 16px 24px; font-weight: 600; color: var(--navy-900);">
                Actions rapides
            </div>
            <div class="card-body">
                <a href="{{ route('documents.index') }}" class="btn-gold-sm w-100 mb-2" style="justify-content: center;">
                    <i class="bi bi-file-earmark-text"></i> Mes documents
                </a>
                <a href="{{ route('meetings.index') }}" class="btn-gold-sm w-100" style="justify-content: center;">
                    <i class="bi bi-calendar-event"></i> Mes réunions
                </a>
            </div>
        </div>
    </div>

    <!-- Colonne droite -->
    <div class="col-lg-8">
        <!-- Informations personnelles -->
        <div class="profile-card mb-3">
            <div class="card-header" style="background: #ffffff; border-bottom: 1px solid #f1f5f9; padding: 16px 24px; font-weight: 600; color: var(--navy-900);">
                <i class="bi bi-person" style="color: var(--gold-500);"></i> Informations personnelles
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nom</label>
                            <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom', $user->nom) }}">
                            @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Prénom</label>
                            <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom', $user->prenom) }}">
                            @error('prenom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Email professionnel</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Service</label>
                            <input type="text" class="form-control" value="{{ $user->department?->nom ?? '—' }}" disabled>
                            <small style="color: var(--navy-600);">Modifiable uniquement par un administrateur.</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Rôle</label>
                            <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" disabled>
                        </div>
                    </div>

                    @if (session('status') === 'profile-updated')
                        <div class="alert alert-success mt-3">
                            <i class="bi bi-check-circle me-2"></i> Profil mis à jour avec succès.
                        </div>
                    @endif

                    <button type="submit" class="btn-gold-sm mt-3">
                        <i class="bi bi-check-lg"></i> Enregistrer
                    </button>
                </form>
            </div>
        </div>

        <!-- Mot de passe -->
        <div class="profile-card mb-3">
            <div class="card-header" style="background: #ffffff; border-bottom: 1px solid #f1f5f9; padding: 16px 24px; font-weight: 600; color: var(--navy-900);">
                <i class="bi bi-key" style="color: var(--gold-500);"></i> Modifier le mot de passe
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Mot de passe actuel</label>
                            <input type="password" name="current_password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror">
                            @error('current_password', 'updatePassword') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Nouveau mot de passe</label>
                            <input type="password" name="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror">
                            @error('password', 'updatePassword') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Confirmer le nouveau mot de passe</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>

                    @if (session('status') === 'password-updated')
                        <div class="alert alert-success mt-3">
                            <i class="bi bi-check-circle me-2"></i> Mot de passe mis à jour avec succès.
                        </div>
                    @endif

                    <button type="submit" class="btn-gold-sm mt-3">
                        <i class="bi bi-key"></i> Mettre à jour le mot de passe
                    </button>
                </form>
            </div>
        </div>

        @if(auth()->user()->isAdmin())
            <div class="danger-zone">
                <div class="card-header">
                    <i class="bi bi-exclamation-triangle"></i> Zone de danger
                </div>
                <div class="card-body">
                    <p style="color: var(--navy-600); margin: 0;">En tant qu'administrateur, vous ne pouvez pas supprimer votre propre compte.</p>
                </div>
            </div>
        @else
            <div class="danger-zone">
                <div class="card-header">
                    <i class="bi bi-trash"></i> Supprimer mon compte
                </div>
                <div class="card-body">
                    <p style="color: var(--navy-600); margin: 0;">Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées.</p>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
