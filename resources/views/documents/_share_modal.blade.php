<div class="modal fade" id="shareDocumentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-share"></i> Partager le document
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('documents.share.store', $document) }}">
                    @csrf
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label">Collaborateurs</label>
                        <select name="user_ids[]" class="form-select" multiple size="8">
                            @foreach($allUsers as $user)
                                <option value="{{ $user->id }}">{{ $user->prenom }} {{ $user->nom }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs collaborateurs.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Droit d'accès</label>
                        <select name="droit" class="form-select">
                            <option value="lecture">Lecture</option>
                            <option value="modification">Modification</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-share"></i> Partager
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
