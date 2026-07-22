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
                                <small class="text-navy-600">{{ $document->fichier ? strtoupper(pathinfo($document->fichier, PATHINFO_EXTENSION)) : '—' }}</small>
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
                        @if($document->fichier)
                            <a href="{{ route('documents.download', $document) }}" class="btn btn-sm btn-success btn-icon" title="Télécharger">
                                <i class="bi bi-download"></i>
                            </a>
                        @endif
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
    {{ $documents->links('pagination.custom') }}
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
                    <style>
                        .checkbox-list {
                            max-height: 220px;
                            overflow-y: auto;
                            border: 1px solid #e2e8f0;
                            border-radius: var(--radius);
                            padding: 10px;
                        }
                        .checkbox-item {
                            border-radius: 8px;
                            transition: background 0.15s, border-left 0.15s;
                            border-left: 3px solid transparent;
                            margin-bottom: 2px;
                        }
                        .checkbox-item:hover {
                            background: #f8fafc;
                        }
                        .checkbox-item:has(.form-check-input:checked) {
                            background: #fefce8;
                            border-left-color: var(--gold-500);
                        }
                        .checkbox-list .form-check {
                            padding: 8px 10px;
                            cursor: pointer;
                            display: flex;
                            align-items: flex-start;
                            gap: 10px;
                        }
                        .checkbox-list .form-check-input {
                            appearance: none;
                            -webkit-appearance: none;
                            width: 18px;
                            height: 18px;
                            border: 2px solid #cbd5e1;
                            border-radius: 4px;
                            background: #fff;
                            cursor: pointer;
                            position: relative;
                            flex-shrink: 0;
                            margin-top: 2px;
                            transition: all 0.15s;
                        }
                        .checkbox-list .form-check-input:checked {
                            background: var(--gold-500);
                            border-color: var(--gold-500);
                        }
                        .checkbox-list .form-check-input:checked::after {
                            content: '';
                            position: absolute;
                            left: 4px;
                            top: 1px;
                            width: 5px;
                            height: 10px;
                            border: solid white;
                            border-width: 0 2px 2px 0;
                            transform: rotate(45deg);
                        }
                        .checkbox-list .form-check-input:focus {
                            box-shadow: 0 0 0 3px rgba(234, 179, 8, 0.15);
                            border-color: var(--gold-500);
                        }
                        .checkbox-list .form-check-label {
                            font-family: 'Inter', sans-serif;
                            font-size: 0.9rem;
                            cursor: pointer;
                            width: 100%;
                        }
                        .mini-avatar {
                            width: 30px;
                            height: 30px;
                            border-radius: 50%;
                            background: linear-gradient(135deg, var(--gold-500) 0%, var(--gold-400) 100%);
                            color: var(--navy-900);
                            display: inline-flex;
                            align-items: center;
                            justify-content: center;
                            font-weight: 700;
                            font-size: 12px;
                            flex-shrink: 0;
                        }
                        .item-primary {
                            font-weight: 500;
                            color: var(--navy-900);
                            line-height: 1.3;
                        }
                        .item-secondary {
                            font-size: 0.8rem;
                            color: var(--navy-600);
                            line-height: 1.3;
                        }
                    </style>
                    <form method="POST" action="#" id="shareForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Collaborateurs</label>
                            <div class="checkbox-list" id="shareUsersList">
                                <div class="text-navy-600" style="padding: 8px 10px; font-size: 0.85rem;">Aucun collaborateur disponible</div>
                            </div>
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
    $allUsersJson = \App\Models\User::orderBy('nom')->get()->map(function ($user) {
        return ['id' => $user->id, 'prenom' => $user->prenom, 'nom' => $user->nom, 'email' => $user->email];
    })->toArray();
    $allUsers = \App\Models\User::orderBy('nom')->get();
    $documentsShareData = $documents->map(function($doc) use ($allUsers) {
        $sharedIds = $doc->sharedWith->pluck('id')->push($doc->user_id);
        $availableUsers = $allUsers->whereNotIn('id', $sharedIds);
        return [
            'id' => $doc->id,
            'titre' => $doc->titre,
            'action' => route('documents.share.store', $doc),
            'owner_id' => $doc->user_id,
            'availableUsers' => $availableUsers->map(function($user) {
                return [
                    'id' => $user->id,
                    'prenom' => $user->prenom,
                    'nom' => $user->nom,
                    'email' => $user->email,
                ];
            })->toArray(),
        ];
    });
@endphp

@push('scripts')
<script>
    window.allUsers = @json($allUsersJson);
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

                var usersList = document.getElementById('shareUsersList');
                if (usersList) {
                    usersList.innerHTML = '';

                    var availableUsers = [];
                    if (data.availableUsers && data.availableUsers.length > 0) {
                        availableUsers = data.availableUsers;
                    } else if (window.allUsers && window.allUsers.length > 0) {
                        var ownerId = data.owner_id || null;
                        availableUsers = window.allUsers.filter(function (u) {
                            return u.id != ownerId;
                        });
                    }

                    if (availableUsers.length === 0) {
                        var emptyDiv = document.createElement('div');
                        emptyDiv.className = 'text-navy-600';
                        emptyDiv.style.padding = '8px 10px';
                        emptyDiv.style.fontSize = '0.85rem';
                        emptyDiv.textContent = 'Aucun collaborateur disponible';
                        usersList.appendChild(emptyDiv);
                    } else {
                        availableUsers.forEach(function (user) {
                            var itemDiv = document.createElement('div');
                            itemDiv.className = 'checkbox-item';

                            var checkDiv = document.createElement('div');
                            checkDiv.className = 'form-check';

                            var checkbox = document.createElement('input');
                            checkbox.className = 'form-check-input';
                            checkbox.type = 'checkbox';
                            checkbox.name = 'user_ids[]';
                            checkbox.value = user.id;
                            checkbox.id = 'share_user_' + user.id;

                            var label = document.createElement('label');
                            label.className = 'form-check-label';
                            label.setAttribute('for', 'share_user_' + user.id);

                            var innerDiv = document.createElement('div');
                            innerDiv.className = 'd-flex align-items-center gap-2';

                            var avatar = document.createElement('div');
                            avatar.className = 'mini-avatar';
                            var prenom = user.prenom || '';
                            var nom = user.nom || '';
                            avatar.textContent = (prenom.charAt(0) + nom.charAt(0)).toUpperCase();

                            var textDiv = document.createElement('div');

                            var primaryDiv = document.createElement('div');
                            primaryDiv.className = 'item-primary';
                            primaryDiv.textContent = prenom + ' ' + nom;

                            var secondaryDiv = document.createElement('div');
                            secondaryDiv.className = 'item-secondary';
                            secondaryDiv.textContent = user.email || '';

                            textDiv.appendChild(primaryDiv);
                            textDiv.appendChild(secondaryDiv);
                            innerDiv.appendChild(avatar);
                            innerDiv.appendChild(textDiv);
                            label.appendChild(innerDiv);
                            checkDiv.appendChild(checkbox);
                            checkDiv.appendChild(label);
                            itemDiv.appendChild(checkDiv);
                            usersList.appendChild(itemDiv);
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
