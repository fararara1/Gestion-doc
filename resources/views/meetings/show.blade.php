@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title"><i class="bi bi-calendar-event"></i> Détail de la réunion</h1>
        <p class="page-subtitle">Informations complètes</p>
    </div>
    <div>
        <a href="{{ route('meetings.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <dl class="row mb-0">
            <x-detail-row label="Titre" :value="$meeting->titre" />
            <x-detail-row label="Description" :value="$meeting->description ?: '—'" />
            <x-detail-row label="Date" :value="$meeting->date->format('d/m/Y')" />
            <x-detail-row label="Horaire" :value="$meeting->heure_debut->format('H:i') . ' - ' . $meeting->heure_fin->format('H:i')" />
            <x-detail-row label="Organisateur" :value="$meeting->organisateur?->prenom . ' ' . $meeting->organisateur?->nom" />
            <dt class="col-sm-3 fw-semibold text-navy-600 detail-row">Participants</dt>
            <dd class="col-sm-9 text-navy-900 detail-row">
                @forelse($meeting->participants as $participant)
                    <span class="badge bg-primary">{{ $participant->prenom }} {{ $participant->nom }}</span>
                @empty
                    —
                @endforelse
            </dd>
            <dt class="col-sm-3 fw-semibold text-navy-600 detail-row">Documents associés</dt>
            <dd class="col-sm-9 text-navy-900 detail-row">
                @forelse($meeting->documents as $document)
                    <a href="{{ route('documents.show', $document) }}" class="badge bg-primary text-decoration-none">{{ $document->titre }}</a>
                @empty
                    —
                @endforelse
            </dd>
        </dl>
    </div>
</div>
@endsection
