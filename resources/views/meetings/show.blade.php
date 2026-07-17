@extends('layouts.app')

@section('content')
<style>
    .page-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .page-header-custom h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--navy-900);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-header-custom h2 i {
        color: var(--gold-500);
    }

    .btn-gold-sm {
        background: linear-gradient(135deg, var(--gold-500) 0%, var(--gold-400) 100%);
        color: var(--navy-900);
        border: none;
        border-radius: var(--radius-sm);
        padding: 10px 20px;
        font-weight: 700;
        font-size: 0.9rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-gold-sm:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(234, 179, 8, 0.25);
        color: var(--navy-900);
    }

    .btn-outline-gold {
        border: 1.5px solid var(--gold-400) !important;
        color: var(--gold-700) !important;
        border-radius: var(--radius-sm) !important;
        font-weight: 600;
        padding: 10px 20px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-outline-gold:hover {
        background: var(--gold-500) !important;
        color: var(--navy-900) !important;
        border-color: var(--gold-500) !important;
    }

    .detail-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    .detail-card .card-body {
        padding: 24px;
    }

    .badge-gold {
        background: linear-gradient(135deg, var(--gold-500) 0%, var(--gold-400) 100%);
        color: var(--navy-900);
        font-weight: 700;
        padding: 0.4em 0.9em;
        border-radius: 50px;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .dl-custom dt {
        font-weight: 600;
        color: var(--navy-600);
        font-size: 0.88rem;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .dl-custom dd {
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
        color: var(--navy-900);
    }

    .dl-custom dt:last-of-type, .dl-custom dd:last-of-type {
        border-bottom: none;
    }
</style>

<div class="page-header-custom">
    <h2><i class="bi bi-calendar-event"></i> Détail de la réunion</h2>
    <div>
        <a href="{{ route('meetings.index') }}" class="btn-outline-gold">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="detail-card">
    <div class="card-body">
        <dl class="row dl-custom mb-0">
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
                    <span class="badge-gold">{{ $participant->prenom }} {{ $participant->nom }}</span>
                @empty
                    —
                @endforelse
            </dd>

            <dt class="col-sm-3">Documents associés</dt>
            <dd class="col-sm-9">
                @forelse($meeting->documents as $document)
                    <a href="{{ route('documents.show', $document) }}" class="badge-gold text-decoration-none">{{ $document->titre }}</a>
                @empty
                    —
                @endforelse
            </dd>
        </dl>
    </div>
</div>
@endsection
