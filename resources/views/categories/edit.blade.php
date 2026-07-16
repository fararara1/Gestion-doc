@extends('layouts.app')

@section('content')
<h2 class="mb-4"><i class="bi bi-pencil-square"></i> Modifier la catégorie</h2>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('categories.update', $category) }}">
            @csrf
            @method('PUT')
            @include('categories._form', ['category' => $category])
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg"></i> Mettre à jour
            </button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
@endsection