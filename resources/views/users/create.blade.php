@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title"><i class="bi bi-person-plus"></i> Nouvel utilisateur</h1>
        <p class="page-subtitle">Créer un compte utilisateur</p>
    </div>
    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            @include('users._form', ['user' => null])
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> Enregistrer
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary ms-2">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
