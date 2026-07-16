@extends('layouts.app')

@section('content')
<h2 class="mb-4"><i class="bi bi-kanban"></i> Nouveau projet</h2>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('projects.store') }}">
            @csrf
            @include('projects._form', ['project' => null])
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg"></i> Enregistrer
            </button>
            <a href="{{ route('projects.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
@endsection