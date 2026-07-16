<x-mail::message>
# Invitation à une réunion

**{{ $meeting->titre }}**

{{ $meeting->description }}

## Détails

- **Date :** {{ \Carbon\Carbon::parse($meeting->date)->format('d/m/Y') }}
- **Heure :** {{ \Carbon\Carbon::parse($meeting->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($meeting->heure_fin)->format('H:i') }}

## Participants

@foreach($meeting->participants as $participant)
- {{ $participant->prenom }} {{ $participant->nom }}
@endforeach

@if($meeting->documents->count() > 0)
## Documents associés

@foreach($meeting->documents as $document)
- {{ $document->titre }}
@endforeach
@endif

<x-mail::button :url="route('meetings.show', $meeting->id)">
Voir la réunion
</x-mail::button>

Merci,<br>
{{ config('app.name') }}
</x-mail::message>