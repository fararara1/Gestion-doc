@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title"><i class="bi bi-tags"></i> Catégories</h1>
        <p class="page-subtitle">Classer vos documents</p>
    </div>
    <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> Nouvelle catégorie
    </a>
</div>

<div class="table-responsive">
    <table class="table align-middle mb-0">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Documents liés</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td class="fw-semibold">{{ $category->nom }}</td>
                    <td>
                        <span class="badge bg-primary">{{ $category->documents_count }}</span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-outline-secondary btn-icon" title="Consulter">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-outline-secondary btn-icon" title="Modifier">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression de cette catégorie ?');">
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
                    <td colspan="3" class="text-center py-4 text-navy-600">Aucune catégorie trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="card-body">
    {{ $categories->links() }}
</div>
@endsection
