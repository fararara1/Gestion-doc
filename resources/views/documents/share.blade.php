@extends('layouts.app')

@section('content')
<h2 class="mb-4"><i class="bi bi-share"></i> Partager « {{ $document->titre }} »</h2>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Ajouter des collaborateurs</div>
            <div class="card-body">
                <form method="POST" action="{{ route('documents.share.store', $document) }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Collaborateurs</label>
                        <select name="user_ids[]" class="form-select @error('user_ids') is-invalid @enderror" multiple size="8">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->prenom }} {{ $user->nom }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs collaborateurs.</small>
                        @error('user_ids') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Droit d'accès</label>
                        <select name="droit" class="form-select @error('droit') is-invalid @enderror">
                            <option value="lecture">Lecture</option>
                            <option value="modification">Modification</option>
                        </select>
                        @error('droit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-share"></i> Partager
                    </button>
                    <a href="{{ route('documents.show', $document) }}" class="btn btn-secondary">Retour</a>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Déjà partagé avec</div>
            <div class="card-body">
                @forelse($document->sharedWith as $sharedUser)
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                        <div>
                            {{ $sharedUser->prenom }} {{ $sharedUser->nom }}
                            <span class="badge {{ $sharedUser->pivot->droit === 'modification' ? 'bg-warning text-dark' : 'bg-secondary' }}">
                                {{ ucfirst($sharedUser->pivot->droit) }}
                            </span>
                        </div>
                        <form action="{{ route('documents.share.destroy', [$document, $sharedUser]) }}" method="POST" onsubmit="return confirm('Révoquer le partage pour cet utilisateur ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-muted mb-0">Ce document n'est partagé avec personne pour le moment.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection