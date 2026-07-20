<div class="modal fade" id="shareDocumentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Partager le document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('documents.share.store', $document) }}" id="shareForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Collaborateurs</label>
                        <select name="user_ids[]" class="form-select" multiple size="6">
                            @foreach($allUsers as $user)
                                <option value="{{ $user->id }}">{{ $user->prenom }} {{ $user->nom }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                        <small style="color: var(--navy-600);">Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs collaborateurs.</small>
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
