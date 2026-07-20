@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title"><i class="bi bi-person"></i> Détail utilisateur</h1>
        <p class="page-subtitle">Profil et informations</p>
    </div>
    <div>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <dl class="row mb-0">
            <x-detail-row label="Nom" :value="$user->nom" />
            <x-detail-row label="Prénom" :value="$user->prenom" />
            <x-detail-row label="Email professionnel" :value="$user->email" />
            <x-detail-row label="Service" :value="$user->department?->nom ?? '—'" />
            <dt class="col-sm-3 fw-semibold text-navy-600 detail-row">Rôle</dt>
            <dd class="col-sm-9 text-navy-900 detail-row">
                @if($user->role === 'administrateur')
                    <span class="badge bg-primary">Admin</span>
                @else
                    <span class="badge bg-light">Collaborateur</span>
                @endif
            </dd>
            <x-detail-row label="Documents ajoutés" :value="$user->documents->count()" />
        </dl>
    </div>
</div>
@endsection
