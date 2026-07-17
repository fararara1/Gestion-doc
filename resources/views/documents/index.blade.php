@extends('layouts.app')

@section('content')
<style>
    .page-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .page-header-custom h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--navy-900);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-header-custom h2 i {
        color: var(--gold-500);
    }

    .filter-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-xl);
        padding: 20px 24px;
        box-shadow: var(--shadow-sm);
        margin-bottom: 20px;
    }

    .filter-card .form-control,
    .filter-card .form-select {
        border-radius: var(--radius-sm);
        border: 1px solid #e2e8f0;
        padding: 10px 14px;
        font-size: 14px;
        transition: var(--transition);
        background: #ffffff;
        font-family: 'Inter', sans-serif;
    }

    .filter-card .form-control:focus,
    .filter-card .form-select:focus {
        border-color: var(--gold-500);
        box-shadow: 0 0 0 3px rgba(234, 179, 8, 0.06);
        outline: none;
    }

    .btn-gold-sm {
        background: linear-gradient(135deg, var(--gold-500) 0%, var(--gold-400) 100%);
        color: var(--navy-900);
        border: none;
        border-radius: var(--radius-sm);
        padding: 10px 20px;
        font-weight: 700;
        font-size: 0.9rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-gold-sm:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(234, 179, 8, 0.25);
        color: var(--navy-900);
    }

    .data-table {
        border-radius: var(--radius-xl);
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        box-shadow: var(--shadow-sm);
    }

    .data-table thead {
        background: var(--navy-900);
        color: #f1f5f9;
    }

    .data-table thead th {
        border: none;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 16px;
        font-family: 'Inter', sans-serif;
    }

    .data-table tbody td {
        padding: 15px 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
    }

    .data-table tbody tr {
        transition: var(--transition);
    }

    .data-table tbody tr:hover {
        background: var(--gold-50);
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    .badge-gold {
        background: linear-gradient(135deg, var(--gold-500) 0%, var(--gold-400) 100%);
        color: var(--navy-900);
        font-weight: 700;
        padding: 0.4em 0.9em;
        border-radius: 50px;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 !important;
        border: 1.5px solid #e2e8f0 !important;
        color: var(--navy-600) !important;
        transition: var(--transition);
        text-decoration: none;
        margin-right: 4px;
    }

    .btn-icon:hover {
        border-color: var(--gold-400) !important;
        color: var(--gold-700) !important;
        background: var(--gold-50) !important;
        transform: scale(1.05);
    }

    .btn-icon-success { border-color: #bbf7d0 !important; color: #16a34a !important; }
    .btn-icon-success:hover { background: #f0fdf4 !important; color: #15803d !important; border-color: #16a34a !important; }

    .btn-icon-warning { border-color: #fde68a !important; color: #d97706 !important; }
    .btn-icon-warning:hover { background: #fffbeb !important; color: #a16207 !important; border-color: #d97706 !important; }

    .btn-icon-danger { border-color: #fecaca !important; color: #dc2626 !important; }
    .btn-icon-danger:hover { background: #fef2f2 !important; color: #991b1b !important; border-color: #dc2626 !important; }

    .btn-icon-info { border-color: #bfdbfe !important; color: #2563eb !important; }
    .btn-icon-info:hover { background: #eff6ff !important; color: #1e40af !important; border-color: #2563eb !important; }

    .card-footer-custom {
        background: #ffffff;
        border-top: 1px solid #f1f5f9;
        padding: 14px 24px;
    }
</style>

<div class="page-header-custom">
    <h2><i class="bi bi-file-earmark-text"></i> Documents</h2>
    <a href="{{ route('documents.create') }}" class="btn-gold-sm">
        <i class="bi bi-plus-lg"></i> Ajouter un document
    </a>
</div>

<div class="filter-card">
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
            <button type="submit" class="btn-gold-sm w-100">
                <i class="bi bi-search"></i> Filtrer
            </button>
        </div>
    </form>
</div>

<div class="data-table">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
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
                        $extension = pathinfo($document->fichier, PATHINFO_EXTENSION);
                        $icon = match(strtolower($extension)) {
                            'pdf' => 'bi-file-earmark-pdf text-danger',
                            'doc', 'docx' => 'bi-file-earmark-word',
                            'xls', 'xlsx' => 'bi-file-earmark-excel text-success',
                            'ppt', 'pptx' => 'bi-file-earmark-ppt',
                            'jpg', 'jpeg', 'png', 'gif' => 'bi-file-earmark-image',
                            default => 'bi-file-earmark-text',
                        };
                        $isShared = $document->sharedWith->count() > 0;
                    @endphp
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi {{ $icon }} fs-4"></i>
                                <div>
                                    <div class="fw-semibold">{{ $document->titre }}</div>
                                    <small style="color: var(--navy-600);">{{ strtoupper($extension) }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $document->project?->nom ?? '—' }}</td>
                        <td>{{ $document->category?->nom ?? '—' }}</td>
                        <td>{{ $document->user?->prenom }} {{ $document->user?->nom }}</td>
                        <td>
                            @if($isShared)
                                <span class="badge-gold">Partagé</span>
                            @else
                                <span style="background: #f1f5f9; color: var(--navy-600); font-weight: 600; padding: 0.4em 0.9em; border-radius: 50px; font-size: 0.72rem; text-transform: uppercase;">Privé</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('documents.show', $document) }}" class="btn-icon btn-icon-info" title="Consulter">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('documents.download', $document) }}" class="btn-icon btn-icon-success" title="Télécharger">
                                <i class="bi bi-download"></i>
                            </a>
                            @if($canManage)
                                <button type="button" class="btn-icon" title="Partager" data-document-id="{{ $document->id }}" id="openShareModal">
                                    <i class="bi bi-share"></i>
                                </button>
                                <a href="{{ route('documents.edit', $document) }}" class="btn-icon btn-icon-warning" title="Modifier">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('documents.destroy', $document) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression de ce document ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon btn-icon-danger" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4" style="color: var(--navy-600);">Aucun document trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer-custom">
        {{ $documents->links() }}
    </div>
</div>

{{-- Modal partage --}}
<div class="modal fade" id="shareDocumentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-family: 'Playfair Display', serif; color: var(--navy-900);">
                    <i class="bi bi-share" style="color: var(--gold-500);"></i> Partager un document
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="#" id="shareForm">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label">Collaborateurs</label>
                        <select name="user_ids[]" class="form-select" multiple size="6" id="shareUsers">
                            <option disabled>Aucun collaborateur disponible</option>
                        </select>
                        <small style="color: var(--navy-600);">Ctrl/Cmd pour multi-sélection.</small>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Droit d'accès</label>
                        <select name="droit" class="form-select">
                            <option value="lecture">Lecture</option>
                            <option value="modification">Modification</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-gold-sm btn-sm">
                        <i class="bi bi-share"></i> Partager
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@php
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

<script>
    window.documentsShareData = @json($documentsShareData);

    document.addEventListener('DOMContentLoaded', function () {
        var shareModalEl = document.getElementById('shareDocumentModal');
        var shareModal = bootstrap.Modal.getInstance(shareModalEl);
        if (!shareModal) {
            shareModal = new bootstrap.Modal(shareModalEl);
        }

        document.querySelectorAll('[data-document-id]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var documentId = this.getAttribute('data-document-id');
                var data = window.documentsShareData.find(function (item) {
                    return item.id == documentId;
                });

                if (!data) {
                    return;
                }

                document.querySelector('#shareDocumentModal .modal-title').innerHTML =
                    '<i class="bi bi-share" style="color: var(--gold-500);"></i> Partager « ' + data.titre + ' »';

                document.getElementById('shareForm').action = data.action;

                var usersSelect = document.getElementById('shareUsers');
                usersSelect.innerHTML = '';

                if (!data.availableUsers || data.availableUsers.length === 0) {
                    usersSelect.innerHTML = '<option disabled>Aucun collaborateur disponible</option>';
                } else {
                    data.availableUsers.forEach(function (user) {
                        var option = document.createElement('option');
                        option.value = user.id;
                        option.textContent = user.nom;
                        usersSelect.appendChild(option);
                    });
                }

                shareModal.show();
            });
        });

        shareModalEl.addEventListener('hidden.bs.modal', function () {
            document.body.classList.remove('modal-open');
            document.querySelectorAll('.modal-backdrop').forEach(function (el) {
                if (el.parentNode) {
                    el.parentNode.removeChild(el);
                }
            });
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        });
    });
</script>
@endsection
