@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title"><i class="bi bi-kanban"></i> Projets</h1>
        <p class="page-subtitle">Organisez vos projets</p>
    </div>
    <a href="{{ route('projects.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> Nouveau projet
    </a>
</div>

<div class="table-responsive">
    <table class="table align-middle mb-0">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Documents liés</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($projects as $project)
                <tr>
                    <td class="fw-semibold">{{ $project->nom }}</td>
                    <td>{{ Str::limit($project->description, 60) ?: '—' }}</td>
                    <td>
                        <span class="badge bg-primary">{{ $project->documents_count }}</span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-outline-secondary btn-icon" title="Consulter">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('projects.edit', $project) }}" class="btn btn-sm btn-outline-secondary btn-icon" title="Modifier">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression de ce projet ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger btn-icon" title="Supprimer">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-navy-600">Aucun projet trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="card-body">
    {{ $projects->links('pagination.custom') }}
</div>
@endsection
