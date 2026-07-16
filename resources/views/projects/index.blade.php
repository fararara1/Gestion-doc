@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-kanban"></i> Projets</h2>
    <a href="{{ route('projects.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Nouveau projet
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
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
                        <td>{{ $project->nom }}</td>
                        <td>{{ Str::limit($project->description, 60) ?: '—' }}</td>
                        <td><span class="badge bg-secondary">{{ $project->documents_count }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('projects.edit', $project) }}" class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression de ce projet ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Aucun projet trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $projects->links() }}
    </div>
</div>
@endsection