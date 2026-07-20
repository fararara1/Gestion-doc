@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title"><i class="bi bi-building"></i> Départements</h1>
        <p class="page-subtitle">Gérez les services</p>
    </div>
    <a href="{{ route('departments.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle"></i> Nouveau département
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success" role="alert">
        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
    </div>
@endif

<div class="card mb-3">
    <div class="card-body">
        @include('components.search-bar', [
            'formId' => 'searchForm',
            'action' => route('departments.index'),
            'inputName' => 'search',
            'inputId' => 'search',
            'placeholder' => 'Rechercher un département...',
        ])
    </div>
</div>

<div class="table-responsive">
    <table class="table align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>Nom du département</th>
                <th>Créé le</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($departments as $department)
                <tr>
                    <td>
                        <span class="badge bg-primary">{{ $loop->iteration }}</span>
                    </td>
                    <td class="fw-semibold">{{ $department->nom }}</td>
                    <td>{{ $department->created_at->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <a href="{{ route('departments.show', $department) }}" class="btn btn-sm btn-outline-secondary btn-icon" title="Consulter">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('departments.edit', $department) }}" class="btn btn-sm btn-outline-secondary btn-icon" title="Modifier">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('departments.destroy', $department) }}" method="POST" class="d-inline" onsubmit="return confirm('Voulez-vous vraiment supprimer ce département ?');">
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
                    <td colspan="4" class="text-center py-5">
                        <div class="text-center" style="padding: 2.5rem 1rem; color: var(--navy-600);">
                            <i class="bi bi-building" style="font-size: 2rem; color: var(--gold-400); margin-bottom: 0.5rem; display: block;"></i>
                            <h5 class="mt-3" style="color: var(--navy-900);">Aucun département trouvé</h5>
                            <p>Cliquez sur <strong>Nouveau département</strong> pour commencer.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-end mt-3" style="padding: 0 24px 16px;">
    {{ $departments->links() }}
</div>
@endsection
