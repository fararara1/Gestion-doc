@extends('layouts.app')

@section('content')
<h2 class="mb-4"><i class="bi bi-person-circle"></i> Mon profil</h2>

<div class="row g-4">
    <!-- Informations personnelles -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Informations personnelles</div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nom</label>
                            <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror"
                                   value="{{ old('nom', $user->nom) }}">
                            @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Prénom</label>
                            <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror"
                                   value="{{ old('prenom', $user->prenom) }}">
                            @error('prenom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Email professionnel</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email) }}">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Service</label>
                            <input type="text" class="form-control" value="{{ $user->department?->nom ?? '—' }}" disabled>
                            <small class="text-muted">Modifiable uniquement par un administrateur.</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Rôle</label>
                            <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" disabled>
                        </div>
                    </div>

                    @if (session('status') === 'profile-updated')
                        <p class="text-success mt-3 mb-0">Profil mis à jour avec succès.</p>
                    @endif

                    <button type="submit" class="btn btn-primary mt-3">
                        <i class="bi bi-check-lg"></i> Enregistrer
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Mot de passe -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Modifier le mot de passe</div>
            <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Mot de passe actuel</label>
                        <input type="password" name="current_password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror">
                        @error('current_password', 'updatePassword') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nouveau mot de passe</label>
                        <input type="password" name="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror">
                        @error('password', 'updatePassword') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirmer le nouveau mot de passe</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    @if (session('status') === 'password-updated')
                        <p class="text-success mb-3">Mot de passe mis à jour avec succès.</p>
                    @endif

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-key"></i> Mettre à jour le mot de passe
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection