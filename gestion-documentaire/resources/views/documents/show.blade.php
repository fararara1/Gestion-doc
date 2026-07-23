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
        <a href="{{ route('documents.download', $document) }}" class="btn btn-primary btn-sm" @if(empty($document->fichier)) style="display:none;" @endif>
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
        $allUsers = $allUsers ?? \App\Models\User::orderBy('nom')->get();
        $sharedIds = $document->sharedWith->pluck('id')->push($document->user_id);
        $availableUsers = $allUsers->whereNotIn('id', $sharedIds);
    @endphp
    <div class="modal fade" id="shareDocumentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
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
                <div class="modal-header">
                    <h5 class="modal-title">Partager « {{ $document->titre }} »</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('documents.share.store', $document) }}" id="shareForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Collaborateurs</label>
                            <div class="checkbox-list">
                                @forelse($availableUsers as $user)
                                    <div class="checkbox-item">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="user_ids[]" value="{{ $user->id }}" id="share_user_{{ $user->id }}">
                                            <label class="form-check-label" for="share_user_{{ $user->id }}">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="mini-avatar">{{ strtoupper(mb_substr($user->prenom, 0, 1) . mb_substr($user->nom, 0, 1)) }}</div>
                                                    <div>
                                                        <div class="item-primary">{{ $user->prenom }} {{ $user->nom }}</div>
                                                        <div class="item-secondary">{{ $user->email }}</div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-navy-600" style="padding: 8px 10px; font-size: 0.85rem;">Aucun collaborateur disponible</div>
                                @endforelse
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
