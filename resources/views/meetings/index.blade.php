@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title"><i class="bi bi-calendar-event"></i> Réunions</h1>
        <p class="page-subtitle">Planifiez et suivez vos réunions</p>
    </div>
    <a href="{{ route('meetings.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> Nouvelle réunion
    </a>
</div>

<div class="table-responsive">
    <table class="table align-middle mb-0">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Date</th>
                <th>Horaire</th>
                <th>Organisateur</th>
                <th>Participants</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($meetings as $meeting)
                <tr>
                    <td class="fw-semibold">{{ $meeting->titre }}</td>
                    <td>{{ $meeting->date->format('d/m/Y') }}</td>
                    <td>{{ $meeting->heure_debut->format('H:i') }} - {{ $meeting->heure_fin->format('H:i') }}</td>
                    <td>{{ $meeting->organisateur?->prenom }} {{ $meeting->organisateur?->nom }}</td>
                    <td>
                        <span class="badge bg-primary">{{ $meeting->participants->count() }} participant(s)</span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('meetings.show', $meeting) }}" class="btn btn-sm btn-outline-secondary btn-icon" title="Consulter">
                            <i class="bi bi-eye"></i>
                        </a>
                        @if(auth()->user()->isAdmin() || auth()->id() === $meeting->user_id)
                            <a href="{{ route('meetings.edit', $meeting) }}" class="btn btn-sm btn-outline-secondary btn-icon" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('meetings.destroy', $meeting) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression de cette réunion ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger btn-icon" title="Supprimer">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-navy-600">Aucune réunion trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="card-body">
    {{ $meetings->links() }}
</div>
@endsection
