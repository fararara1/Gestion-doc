@extends('layouts.app')

@section('content')
<h2 class="mb-4"><i class="bi bi-tags"></i> Nouvelle catégorie</h2>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('categories.store') }}">
            @csrf
            @include('categories._form', ['category' => null])
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg"></i> Enregistrer
            </button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
@endsection