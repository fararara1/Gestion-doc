@extends('layouts.app')

@section('content')
<h2 class="mb-4"><i class="bi bi-file-earmark-plus"></i> Ajouter un document</h2>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data">
            @csrf
            @include('documents._form', ['document' => null])
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg"></i> Enregistrer
            </button>
            <a href="{{ route('documents.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
@endsection