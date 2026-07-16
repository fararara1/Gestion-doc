@extends('layouts.app')

@section('content')
<h2 class="mb-4"><i class="bi bi-calendar-event"></i> Détail de la réunion</h2>

<div class="card">
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Titre</dt>
            <dd class="col-sm-9">{{ $meeting->titre }}</dd>

            <dt class="col-sm-3">Description</dt>
            <dd class="col-sm-9">{{ $meeting->description ?: '—' }}</dd>

            <dt class="col-sm-3">Date</dt>
            <dd class="col-sm-9">{{ $meeting->date->format('d/m/Y') }}</dd>

            <dt class="col-sm-3">Horaire</dt>
            <dd class="col-sm-9">{{ $meeting->heure_debut }} - {{ $meeting->heure_fin }}</dd>

            <dt class="col-sm-3">Organisateur</dt>
            <dd class="col-sm-9">{{ $meeting->organisateur?->prenom }} {{ $meeting->organisateur?->nom }}</dd>

            <dt class="col-sm-3">Participants</dt>
            <dd class="col-sm-9">
                @forelse($meeting->participants as $participant)
                    <span class="badge bg-info text-dark">{{ $participant->prenom }} {{ $participant->nom }}</span>
                @empty
                    —
                @endforelse
            </dd>

            <dt class="col-sm-3">Documents associés</dt>
            <dd class="col-sm-9">
                @forelse($meeting->documents as $document)
                    <a href="{{ route('documents.show', $document) }}" class="badge bg-primary text-decoration-none">
                        {{ $document->titre }}
                    </a>
                @empty
                    —
                @endforelse
            </dd>
        </dl>

        <a href="{{ route('meetings.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>
@endsection