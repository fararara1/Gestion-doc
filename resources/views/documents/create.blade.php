@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title"><i class="bi bi-file-earmark-plus"></i> Ajouter un document</h1>
        <p class="page-subtitle">Créer un nouveau document</p>
    </div>
    <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data">
            @csrf
            @include('documents._form', ['document' => null])
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> Enregistrer
                </button>
                <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary ms-2">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
