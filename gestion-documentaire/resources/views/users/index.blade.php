@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title"><i class="bi bi-people"></i> Utilisateurs</h1>
        <p class="page-subtitle">Gérer les utilisateurs</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> Nouvel utilisateur
    </a>
</div>

<div class="card mb-3">
    <div class="card-body">
        @include('components.search-bar', [
            'formId' => 'searchForm',
            'action' => route('users.index'),
            'inputName' => 'recherche',
            'inputId' => 'recherche',
            'placeholder' => 'Rechercher un utilisateur...',
        ])
    </div>
</div>

<div class="table-responsive">
    <table class="table align-middle mb-0">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Service</th>
                <th>Rôle</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td class="fw-semibold">{{ $user->nom }}</td>
                    <td>{{ $user->prenom }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->department?->nom ?? '—' }}</td>
                    <td>
                        @if($user->role === 'administrateur')
                            <span class="badge bg-primary">Admin</span>
                        @else
                            <span class="badge bg-light">Collaborateur</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-outline-secondary btn-icon" title="Consulter">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-secondary btn-icon" title="Modifier">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression de cet utilisateur ?');">
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
                    <td colspan="6" class="text-center py-4 text-navy-600">Aucun utilisateur trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="card-body">
    {{ $users->links('pagination.custom') }}
</div>
@endsection
