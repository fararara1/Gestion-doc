@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-file-earmark-text"></i> Détail du document</h2>
    <div>
        @php
            $canManage = auth()->user()->isAdmin() || auth()->id() === $document->user_id;
        @endphp
        @if($canManage)
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#shareDocumentModal">
                <i class="bi bi-share"></i> Partager
            </button>
        @endif
        <a href="{{ route('documents.download', $document) }}" class="btn btn-success">
            <i class="bi bi-download"></i> Télécharger
        </a>
        <a href="{{ route('documents.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Titre</dt>
            <dd class="col-sm-9">{{ $document->titre }}</dd>

            <dt class="col-sm-3">Description</dt>
            <dd class="col-sm-9">{{ $document->description ?: '—' }}</dd>

            <dt class="col-sm-3">Projet</dt>
            <dd class="col-sm-9">{{ $document->project?->nom ?? '—' }}</dd>

            <dt class="col-sm-3">Catégorie</dt>
            <dd class="col-sm-9">{{ $document->category?->nom ?? '—' }}</dd>

            <dt class="col-sm-3">Département</dt>
            <dd class="col-sm-9">{{ $document->department?->nom ?? '—' }}</dd>

            <dt class="col-sm-3">Auteur</dt>
            <dd class="col-sm-9">{{ $document->user?->prenom }} {{ $document->user?->nom }}</dd>

            <dt class="col-sm-3">Date d'ajout</dt>
            <dd class="col-sm-9">{{ $document->created_at->format('d/m/Y à H:i') }}</dd>
        </dl>
    </div>
</div>

@if($canManage)
    @include('documents._share_modal', ['document' => $document, 'allUsers' => $allUsers])
@endif
@endsection