@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-people"></i> Utilisateurs</h2>
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Nouvel utilisateur
    </a>
</div>

<div class="card mb-3">
    <div class="card-body">
     <form id="searchForm" method="GET" action="{{ route('users.index') }}" class="mb-4">

    <div class="input-group">

        <span class="input-group-text">
            <i class="bi bi-search"></i>
        </span>

        <input
            type="text"
            id="recherche"
            name="recherche"
            class="form-control"
            placeholder="Rechercher un utilisateur..."
            value="{{ request('recherche') }}"
            autocomplete="off"
            onkeyup="liveSearch()">

    </div>

</form>

<script>
let timer;

function liveSearch() {
    clearTimeout(timer);

    timer = setTimeout(function () {
        document.getElementById('searchForm').submit();
    }, 300);
}
</script>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
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
                        <td>{{ $user->nom }}</td>
                        <td>{{ $user->prenom }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->department?->nom ?? '—' }}</td>
                        <td>
                            <span class="badge {{ $user->role === 'administrateur' ? 'bg-danger' : 'bg-secondary' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression de cet utilisateur ?');">
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
                        <td colspan="6" class="text-center text-muted py-4">Aucun utilisateur trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $users->links() }}
    </div>
</div>
@endsection