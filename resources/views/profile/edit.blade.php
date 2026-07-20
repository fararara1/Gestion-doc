@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title"><i class="bi bi-person-circle"></i> Mon profil</h1>
        <p class="page-subtitle">Gérez vos informations</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-body text-center">
                <div class="profile-avatar" style="width: 96px; height: 96px; border-radius: var(--radius-lg); background: linear-gradient(135deg, var(--gold-500) 0%, var(--gold-400) 100%); color: var(--navy-900); display: inline-flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 700; margin-bottom: 16px; box-shadow: 0 4px 12px rgba(234, 179, 8, 0.2);">
                    {{ strtoupper(mb_substr($user->prenom, 0, 1) . mb_substr($user->nom, 0, 1)) }}
                </div>
                <h4 class="font-display" style="font-size: 1.35rem; font-weight: 700; color: var(--navy-900); margin: 0;">{{ $user->prenom }} {{ $user->nom }}</h4>
                <span class="badge bg-primary mt-2">{{ $user->isAdmin() ? 'Administrateur' : 'Collaborateur' }}</span>
                <p class="text-navy-600 mt-2" style="font-size: 0.9rem;">{{ $user->email }}</p>
                @if($user->department)
                    <a href="{{ route('departments.show', $user->department) }}" class="text-navy-700 mt-2 d-inline-block" style="font-size: 0.88rem; font-weight: 600; text-decoration: none;">
                        <i class="bi bi-building"></i> {{ $user->department->nom }}
                    </a>
                @endif
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">Statistiques</div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span class="text-navy-600" style="font-size: 0.9rem;">Documents créés</span>
                    <span class="badge bg-primary">{{ $user->documents->count() }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span class="text-navy-600" style="font-size: 0.9rem;">Documents partagés</span>
                    <span class="badge bg-primary">{{ $user->sharedDocuments->count() }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span class="text-navy-600" style="font-size: 0.9rem;">Réunions</span>
                    <span class="badge bg-primary">{{ $user->meetings->count() }}</span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Actions rapides</div>
            <div class="card-body">
                <a href="{{ route('documents.index') }}" class="btn btn-primary w-100 mb-2">
                    <i class="bi bi-file-earmark-text"></i> Mes documents
                </a>
                <a href="{{ route('meetings.index') }}" class="btn btn-primary w-100">
                    <i class="bi bi-calendar-event"></i> Mes réunions
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header">
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
                            <small class="text-navy-600">Modifiable uniquement par un administrateur.</small>
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

                    <button type="submit" class="btn btn-primary mt-3">
                        <i class="bi bi-check-lg"></i> Enregistrer
                    </button>
                </form>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
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

                    <button type="submit" class="btn btn-primary mt-3">
                        <i class="bi bi-key"></i> Mettre à jour le mot de passe
                    </button>
                </form>
            </div>
        </div>

        @if(auth()->user()->isAdmin())
            <div class="card">
                <div class="card-header" style="background: var(--navy-900); color: #ffffff; border-bottom: none;">
                    <i class="bi bi-exclamation-triangle"></i> Zone de danger
                </div>
                <div class="card-body">
                    <p class="text-navy-600 mb-0">En tant qu'administrateur, vous ne pouvez pas supprimer votre propre compte.</p>
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-header" style="background: #dc2626; color: #ffffff; border-bottom: none;">
                    <i class="bi bi-trash"></i> Supprimer mon compte
                </div>
                <div class="card-body">
                    <p class="text-navy-600 mb-0">Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées.</p>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
