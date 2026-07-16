@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-calendar-event"></i> Réunions</h2>
    <a href="{{ route('meetings.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Nouvelle réunion
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
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
                        <td>{{ $meeting->titre }}</td>
                        <td>{{ $meeting->date->format('d/m/Y') }}</td>
                        <td>{{ $meeting->heure_debut }} - {{ $meeting->heure_fin }}</td>
                        <td>{{ $meeting->organisateur?->prenom }} {{ $meeting->organisateur?->nom }}</td>
                        <td><span class="badge bg-secondary">{{ $meeting->participants->count() }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('meetings.show', $meeting) }}" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if(auth()->user()->isAdmin() || auth()->id() === $meeting->user_id)
                                <a href="{{ route('meetings.edit', $meeting) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('meetings.destroy', $meeting) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression de cette réunion ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Aucune réunion trouvée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $meetings->links() }}
    </div>
</div>
@endsection