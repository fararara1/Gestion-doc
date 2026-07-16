@extends('layouts.app')

@section('content')
<h2 class="mb-4"><i class="bi bi-pencil-square"></i> Modifier le projet</h2>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('projects.update', $project) }}">
            @csrf
            @method('PUT')
            @include('projects._form', ['project' => $project])
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg"></i> Mettre à jour
            </button>
            <a href="{{ route('projects.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
@endsection