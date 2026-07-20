@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title"><i class="bi bi-file-earmark-text"></i> Détail du document</h1>
        <p class="page-subtitle">Informations et partage</p>
    </div>
    <div>
        @php
            $canManage = auth()->user()->isAdmin() || auth()->id() === $document->user_id;
        @endphp
        @if($canManage)
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#shareDocumentModal">
                <i class="bi bi-share"></i> Partager
            </button>
        @endif
        <a href="{{ route('documents.download', $document) }}" class="btn btn-primary btn-sm">
            <i class="bi bi-download"></i> Télécharger
        </a>
        <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <dl class="row mb-0">
            <x-detail-row label="Titre" :value="$document->titre" />
            <x-detail-row label="Description" :value="$document->description ?: '—'" />
            <x-detail-row label="Projet" :value="$document->project?->nom ?? '—'" />
            <x-detail-row label="Catégorie" :value="$document->category?->nom ?? '—'" />
            <x-detail-row label="Département" :value="$document->department?->nom ?? '—'" />
            <x-detail-row label="Auteur" :value="$document->user?->prenom . ' ' . $document->user?->nom" />
            <x-detail-row label="Date d'ajout" :value="$document->created_at->format('d/m/Y à H:i')" />
        </dl>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">Fichier</div>
    <div class="card-body">
        @if($document->fichier)
            @php
                $extension = pathinfo($document->fichier, PATHINFO_EXTENSION);
            @endphp
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-file-earmark-text" style="font-size: 2rem; color: var(--navy-600);"></i>
                <div>
                    <p class="mb-1"><strong>{{ basename($document->fichier) }}</strong></p>
                    <span class="badge bg-primary">{{ strtoupper($extension) }}</span>
                    <a href="{{ route('documents.download', $document) }}" class="btn btn-primary btn-sm ms-2">
                        <i class="bi bi-download"></i> Télécharger
                    </a>
                </div>
            </div>
        @else
            <p class="text-navy-600 mb-0">Aucun fichier attaché.</p>
        @endif
    </div>
</div>

@if($canManage)
    @php
        $sharedIds = $document->sharedWith->pluck('id')->push($document->user_id);
        $availableUsers = $allUsers->whereNotIn('id', $sharedIds);
    @endphp
    <div class="modal fade" id="shareDocumentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Partager « {{ $document->titre }} »</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('documents.share.store', $document) }}" id="shareForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Collaborateurs</label>
                            <select name="user_ids[]" class="form-select" multiple size="6">
                                @forelse($availableUsers as $user)
                                    <option value="{{ $user->id }}">{{ $user->prenom }} {{ $user->nom }}</option>
                                @empty
                                    <option disabled>Aucun collaborateur disponible</option>
                                @endforelse
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

    <div class="card mt-3">
        <div class="card-header">
            <i class="bi bi-people" style="color: var(--gold-500);"></i> Partagé avec
        </div>
        <div class="card-body">
            @forelse($document->sharedWith as $sharedUser)
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <div>
                        {{ $sharedUser->prenom }} {{ $sharedUser->nom }}
                        <span class="badge {{ $sharedUser->pivot->droit === 'modification' ? 'bg-primary' : 'bg-light' }}">
                            {{ ucfirst($sharedUser->pivot->droit) }}
                        </span>
                    </div>
                    <form action="{{ route('documents.share.destroy', [$document, $sharedUser]) }}" method="POST" onsubmit="return confirm('Révoquer ce partage ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger btn-icon" title="Révoquer">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </form>
                </div>
            @empty
                <p class="mb-0 text-navy-600" style="font-size: 0.88rem;">Pas encore partagé.</p>
            @endforelse
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var shareModalEl = document.getElementById('shareDocumentModal');
            if (shareModalEl) {
                var shareModal = bootstrap.Modal.getInstance(shareModalEl);
                if (!shareModal) {
                    shareModal = new bootstrap.Modal(shareModalEl);
                }

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
            }
        });
    </script>
@endif
@endsection
