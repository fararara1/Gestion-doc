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

    .btn-outline-gold {
        border: 1.5px solid var(--gold-400) !important;
        color: var(--gold-700) !important;
        border-radius: var(--radius-sm) !important;
        font-weight: 600;
        padding: 10px 20px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-outline-gold:hover {
        background: var(--gold-500) !important;
        color: var(--navy-900) !important;
        border-color: var(--gold-500) !important;
    }

    .detail-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .detail-card .card-body {
        padding: 24px;
    }

    .detail-card .card-header {
        background: #ffffff;
        border-bottom: 1px solid #f1f5f9;
        padding: 16px 24px;
        font-weight: 600;
        color: var(--navy-900);
    }

    .detail-card .card-header i {
        color: var(--gold-500);
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

    .dl-custom dt {
        font-weight: 600;
        color: var(--navy-600);
        font-size: 0.88rem;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .dl-custom dd {
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
        color: var(--navy-900);
    }

    .dl-custom dt:last-of-type, .dl-custom dd:last-of-type {
        border-bottom: none;
    }

    .share-section {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        margin-top: 20px;
    }

    .share-section .card-body {
        padding: 24px;
    }
</style>

<div class="page-header-custom">
    <h2><i class="bi bi-file-earmark-text"></i> Détail du document</h2>
    <div>
        @php
            $canManage = auth()->user()->isAdmin() || auth()->id() === $document->user_id;
        @endphp
        @if($canManage)
            <button type="button" class="btn-gold-sm" data-bs-toggle="modal" data-bs-target="#shareDocumentModal">
                <i class="bi bi-share"></i> Partager
            </button>
        @endif
        <a href="{{ route('documents.download', $document) }}" class="btn-gold-sm">
            <i class="bi bi-download"></i> Télécharger
        </a>
        <a href="{{ route('documents.index') }}" class="btn-outline-gold">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="detail-card mb-3">
    <div class="card-body">
        <dl class="row dl-custom mb-0">
            <dt class="col-sm-3">Titre</dt>
            <dd class="col-sm-9">{{ $document->titre }}</dd>

            <dt class="col-sm-3">Description</dt>
            <dd class="col-sm-9">{{ $document->description ?: '—' }}</dd>

            <dt class="col-sm-3">Projet</dt>
            <dd class="col-sm-9">{{ $document->project?->nom ?? '—' }}</dd>

            <dt class="col-sm-3">Catégorie</dt>
            <dd class="col-sm-9">{{ $document->category?->nom ?? '—' }}</dd>

            <dt class="col-sm-3">Département</dt>
            <dd class="col-sm-9">{{ $document->department?->nom ?? '—' }}</dd>

            <dt class="col-sm-3">Auteur</dt>
            <dd class="col-sm-9">{{ $document->user?->prenom }} {{ $document->user?->nom }}</dd>

            <dt class="col-sm-3">Date d'ajout</dt>
            <dd class="col-sm-9">{{ $document->created_at->format('d/m/Y à H:i') }}</dd>
        </dl>
    </div>
</div>

<div class="detail-card mb-3">
    <div class="card-header">
        <i class="bi bi-file-earmark-text"></i> Fichier
    </div>
    <div class="card-body">
        @if($document->fichier)
            @php
                $extension = pathinfo($document->fichier, PATHINFO_EXTENSION);
                $icon = match(strtolower($extension)) {
                    'pdf' => 'bi-file-earmark-pdf text-danger',
                    'doc', 'docx' => 'bi-file-earmark-word',
                    'xls', 'xlsx' => 'bi-file-earmark-excel text-success',
                    'ppt', 'pptx' => 'bi-file-earmark-ppt',
                    'jpg', 'jpeg', 'png', 'gif' => 'bi-file-earmark-image',
                    default => 'bi-file-earmark-text',
                };
            @endphp
            <div class="d-flex align-items-center gap-3">
                <i class="bi {{ $icon }} fs-1"></i>
                <div>
                    <p class="mb-1"><strong>{{ basename($document->fichier) }}</strong></p>
                    <span class="badge-gold">{{ strtoupper($extension) }}</span>
                    <a href="{{ route('documents.download', $document) }}" class="btn-gold-sm btn-sm ms-2">
                        <i class="bi bi-download"></i> Télécharger
                    </a>
                </div>
            </div>
        @else
            <p style="color: var(--navy-600); margin: 0;">Aucun fichier attaché.</p>
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
                    <h5 class="modal-title" style="font-family: 'Playfair Display', serif; color: var(--navy-900);">
                        <i class="bi bi-share" style="color: var(--gold-500);"></i> Partager « {{ $document->titre }} »
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('documents.share.store', $document) }}" id="shareForm">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Collaborateurs</label>
                            <select name="user_ids[]" class="form-select" multiple size="6">
                                @forelse($availableUsers as $user)
                                    <option value="{{ $user->id }}">{{ $user->prenom }} {{ $user->nom }}</option>
                                @empty
                                    <option disabled>Aucun collaborateur disponible</option>
                                @endforelse
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

    <div class="share-section">
        <div class="card-header" style="background: #ffffff; border-bottom: 1px solid #f1f5f9; padding: 16px 24px; font-weight: 600; color: var(--navy-900);">
            <i class="bi bi-people" style="color: var(--gold-500);"></i> Partagé avec
        </div>
        <div class="card-body">
            @forelse($document->sharedWith as $sharedUser)
                <div class="d-flex justify-content-between align-items-center border-bottom py-2" style="border-bottom-color: #f1f5f9 !important;">
                    <div>
                        {{ $sharedUser->prenom }} {{ $sharedUser->nom }}
                        <span class="{{ $sharedUser->pivot->droit === 'modification' ? 'badge-gold' : '' }}" @if($sharedUser->pivot->droit !== 'modification') style="background: #f1f5f9; color: var(--navy-600); font-weight: 600; padding: 0.4em 0.9em; border-radius: 50px; font-size: 0.72rem; text-transform: uppercase;" @endif>
                            {{ ucfirst($sharedUser->pivot->droit) }}
                        </span>
                    </div>
                    <form action="{{ route('documents.share.destroy', [$document, $sharedUser]) }}" method="POST" onsubmit="return confirm('Révoquer ce partage ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-icon btn-icon-danger" title="Révoquer">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </form>
                </div>
            @empty
                <p class="mb-0" style="color: var(--navy-600); font-size: 0.88rem;">Pas encore partagé.</p>
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