@extends('layouts.app')

@section('content')
<h2 class="mb-4"><i class="bi bi-person"></i> Détail utilisateur</h2>

<div class="card">
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Nom</dt>
            <dd class="col-sm-9">{{ $user->nom }}</dd>

            <dt class="col-sm-3">Prénom</dt>
            <dd class="col-sm-9">{{ $user->prenom }}</dd>

            <dt class="col-sm-3">Email professionnel</dt>
            <dd class="col-sm-9">{{ $user->email }}</dd>

            <dt class="col-sm-3">Service</dt>
            <dd class="col-sm-9">{{ $user->department?->nom ?? '—' }}</dd>

            <dt class="col-sm-3">Rôle</dt>
            <dd class="col-sm-9">
                <span class="badge {{ $user->role === 'administrateur' ? 'bg-danger' : 'bg-secondary' }}">
                    {{ ucfirst($user->role) }}
                </span>
            </dd>

            <dt class="col-sm-3">Documents ajoutés</dt>
            <dd class="col-sm-9">{{ $user->documents->count() }}</dd>
        </dl>

        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>
@endsection