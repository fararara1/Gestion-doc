@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-file-earmark-text"></i> Documents</h2>
    <a href="{{ route('documents.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Ajouter un document
    </a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('documents.index') }}" class="row g-2">
            <div class="col-md-3">
                <input type="text" name="recherche" class="form-control" placeholder="Rechercher un titre..." value="{{ request('recherche') }}">
            </div>
            <div class="col-md-3">
                <select name="project_id" class="form-select">
                    <option value="">Tous les projets</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>{{ $project->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="category_id" class="form-select">
                    <option value="">Toutes catégories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="department_id" class="form-select">
                    <option value="">Tous départements</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>{{ $department->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-search"></i> Filtrer
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Titre</th>
                    <th>Projet</th>
                    <th>Catégorie</th>
                    <th>Département</th>
                    <th>Auteur</th>
                    <th>Date d'ajout</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($documents as $document)
                    @php
                        $canManage = auth()->user()->isAdmin() || auth()->id() === $document->user_id;
                    @endphp
                    <tr>
                        <td>{{ $document->titre }}</td>
                        <td>{{ $document->project?->nom ?? '—' }}</td>
                        <td>{{ $document->category?->nom ?? '—' }}</td>
                        <td>{{ $document->department?->nom ?? '—' }}</td>
                        <td>{{ $document->user?->prenom }} {{ $document->user?->nom }}</td>
                        <td>{{ $document->created_at->format('d/m/Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('documents.show', $document) }}" class="btn btn-sm btn-outline-info" title="Consulter">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('documents.download', $document) }}" class="btn btn-sm btn-outline-success" title="Télécharger">
                                <i class="bi bi-download"></i>
                            </a>
                            @if($canManage)
                                <button type="button" class="btn btn-sm btn-outline-primary" title="Partager"
                                        data-bs-toggle="modal" data-bs-target="#shareModal{{ $document->id }}">
                                    <i class="bi bi-share"></i>
                                </button>
                                <a href="{{ route('documents.edit', $document) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('documents.destroy', $document) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression de ce document ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Aucun document trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $documents->links() }}
    </div>
</div>

@if(isset($documents) && $documents->count() > 0)
    @php
        $manageableDocuments = $documents->filter(fn($d) => auth()->user()->isAdmin() || auth()->id() === $d->user_id);
    @endphp

    @foreach($manageableDocuments as $document)
        @php
            $sharedIds = $document->sharedWith->pluck('id')->push($document->user_id);
            $availableUsers = $allUsers->whereNotIn('id', $sharedIds);
        @endphp
        <div class="modal fade" id="shareModal{{ $document->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-share"></i> Partager « {{ $document->titre }} »
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <h6>Ajouter des collaborateurs</h6>
                                <form method="POST" action="{{ route('documents.share.store', $document) }}">
                                    @csrf
                                    <div class="mb-2">
                                        <select name="user_ids[]" class="form-select" multiple size="6">
                                            @forelse($availableUsers as $user)
                                                <option value="{{ $user->id }}">
                                                    {{ $user->prenom }} {{ $user->nom }}
                                                </option>
                                            @empty
                                                <option disabled>Aucun collaborateur disponible</option>
                                            @endforelse
                                        </select>
                                        <small class="text-muted">Ctrl/Cmd pour multi-sélection.</small>
                                    </div>
                                    <div class="mb-2">
                                        <select name="droit" class="form-select">
                                            <option value="lecture">Lecture</option>
                                            <option value="modification">Modification</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="bi bi-share"></i> Partager
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <h6>Déjà partagé avec</h6>
                                @forelse($document->sharedWith as $sharedUser)
                                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                        <div>
                                            {{ $sharedUser->prenom }} {{ $sharedUser->nom }}
                                            <span class="badge {{ $sharedUser->pivot->droit === 'modification' ? 'bg-warning text-dark' : 'bg-secondary' }}">
                                                {{ ucfirst($sharedUser->pivot->droit) }}
                                            </span>
                                        </div>
                                        <form action="{{ route('documents.share.destroy', [$document, $sharedUser]) }}" method="POST" onsubmit="return confirm('Révoquer ce partage ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                @empty
                                    <p class="text-muted small mb-0">Pas encore partagé.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
@endsection
