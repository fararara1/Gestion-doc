@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title"><i class="bi bi-file-earmark-text"></i> Documents</h1>
        <p class="page-subtitle">Gérez vos documents</p>
    </div>
    <a href="{{ route('documents.create') }}" class="btn btn-primary btn-sm">
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
                <button type="submit" class="btn btn-primary btn-sm w-100">
                    <i class="bi bi-search"></i> Filtrer
                </button>
            </div>
        </form>
    </div>
</div>

<div class="table-responsive">
    <table class="table align-middle mb-0">
        <thead>
            <tr>
                <th>Document</th>
                <th>Projet</th>
                <th>Catégorie</th>
                <th>Auteur</th>
                <th>Statut</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($documents as $document)
                @php
                    $canManage = auth()->user()->isAdmin() || auth()->id() === $document->user_id;
                @endphp
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-file-earmark-text text-navy-600" style="font-size: 1.25rem;"></i>
                            <div>
                                <div class="fw-semibold">{{ $document->titre }}</div>
                                <small class="text-navy-600">{{ strtoupper(pathinfo($document->fichier, PATHINFO_EXTENSION)) }}</small>
                            </div>
                        </div>
                    </td>
                    <td>{{ $document->project?->nom ?? '—' }}</td>
                    <td>{{ $document->category?->nom ?? '—' }}</td>
                    <td>{{ $document->user?->prenom }} {{ $document->user?->nom }}</td>
                    <td>
                        @if($document->sharedWith->count() > 0)
                            <span class="badge bg-primary">Partagé</span>
                        @else
                            <span class="badge bg-light">Privé</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('documents.show', $document) }}" class="btn btn-sm btn-outline-secondary" title="Consulter">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('documents.download', $document) }}" class="btn btn-sm btn-success btn-icon" title="Télécharger">
                            <i class="bi bi-download"></i>
                        </a>
                        @if($canManage)
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-icon" title="Partager" data-document-id="{{ $document->id }}" data-bs-toggle="modal" data-bs-target="#shareDocumentModal">
                                <i class="bi bi-share"></i>
                            </button>
                            <a href="{{ route('documents.edit', $document) }}" class="btn btn-sm btn-outline-secondary btn-icon" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('documents.destroy', $document) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression de ce document ?');">
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
                    <td colspan="6" class="text-center py-4 text-navy-600">Aucun document trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="card-body">
    {{ $documents->links() }}
</div>

{{-- Modal partage --}}
<div class="modal fade" id="shareDocumentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Partager un document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="#" id="shareForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Collaborateurs</label>
                        <select name="user_ids[]" class="form-select" multiple size="6" id="shareUsers">
                            <option disabled>Aucun collaborateur disponible</option>
                        </select>
                        <small class="text-navy-600">Ctrl/Cmd pour multi-sélection.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Droit d'accès</label>
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
        </div>
    </div>
</div>

@php
    $allUsers = $allUsers ?? User::orderBy('nom')->get();
    $documentsShareData = $documents->map(function($doc) use ($allUsers) {
        $sharedIds = $doc->sharedWith->pluck('id')->push($doc->user_id);
        $availableUsers = $allUsers->whereNotIn('id', $sharedIds);
        return [
            'id' => $doc->id,
            'titre' => $doc->titre,
            'action' => route('documents.share.store', $doc),
            'availableUsers' => $availableUsers->map(function($user) {
                return [
                    'id' => $user->id,
                    'nom' => $user->prenom . ' ' . $user->nom,
                ];
            })->toArray(),
        ];
    });
@endphp

@push('scripts')
<script>
    window.documentsShareData = @json($documentsShareData);

    document.addEventListener('DOMContentLoaded', function () {
        var shareModalEl = document.getElementById('shareDocumentModal');
        if (!shareModalEl) {
            return;
        }

        var shareModal = bootstrap.Modal.getOrCreateInstance(shareModalEl);

        document.querySelectorAll('[data-document-id]').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                var documentId = this.getAttribute('data-document-id');
                var data = window.documentsShareData.find(function (item) {
                    return item.id == documentId;
                });

                if (!data) {
                    return;
                }

                var titleEl = document.querySelector('#shareDocumentModal .modal-title');
                if (titleEl) {
                    titleEl.textContent = 'Partager \u00AB ' + data.titre + ' \u00BB';
                }

                var form = document.getElementById('shareForm');
                if (form) {
                    form.action = data.action;
                }

                var usersSelect = document.getElementById('shareUsers');
                if (usersSelect) {
                    usersSelect.innerHTML = '';

                    if (!data.availableUsers || data.availableUsers.length === 0) {
                        var emptyOption = document.createElement('option');
                        emptyOption.disabled = true;
                        emptyOption.textContent = 'Aucun collaborateur disponible';
                        usersSelect.appendChild(emptyOption);
                    } else {
                        data.availableUsers.forEach(function (user) {
                            var option = document.createElement('option');
                            option.value = user.id;
                            option.textContent = user.nom;
                            usersSelect.appendChild(option);
                        });
                    }
                }

                shareModal.show();
            });
        });
    });
</script>
@endpush
@endsection
