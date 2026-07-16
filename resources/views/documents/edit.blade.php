@extends('layouts.app')

@section('content')
<h2 class="mb-4"><i class="bi bi-pencil-square"></i> Modifier le document</h2>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('documents.update', $document) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('documents._form', ['document' => $document])
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg"></i> Mettre à jour
            </button>
            <a href="{{ route('documents.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
@endsection