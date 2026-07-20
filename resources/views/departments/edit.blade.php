@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title"><i class="bi bi-building"></i> Modifier le département</h1>
        <p class="page-subtitle">Mettre à jour</p>
    </div>
    <a href="{{ route('departments.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
</div>

<div class="card">
    <div class="card-header">Modifier un département</div>
    <div class="card-body">
        <form method="POST" action="{{ route('departments.update', $department) }}">
            @csrf
            @method('PUT')
            @include('departments._form')
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> Modifier
                </button>
                <a href="{{ route('departments.index') }}" class="btn btn-outline-secondary ms-2">Retour</a>
            </div>
        </form>
    </div>
</div>
@endsection
