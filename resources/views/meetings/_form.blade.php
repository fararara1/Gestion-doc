<div class="row g-3">
    <div class="col-md-12">
        <label class="form-label">Titre</label>
        <input type="text" name="titre" class="form-control @error('titre') is-invalid @enderror"
               value="{{ old('titre', $meeting->titre ?? '') }}">
        @error('titre') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-12">
        <label class="form-label">Description</label>
        <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $meeting->description ?? '') }}</textarea>
        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Date</label>
        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
               value="{{ old('date', isset($meeting) ? $meeting->date->format('Y-m-d') : '') }}">
        @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Heure de début</label>
        <input type="time" name="heure_debut" class="form-control @error('heure_debut') is-invalid @enderror"
               value="{{ old('heure_debut', $meeting->heure_debut ?? '') }}">
        @error('heure_debut') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Heure de fin</label>
        <input type="time" name="heure_fin" class="form-control @error('heure_fin') is-invalid @enderror"
               value="{{ old('heure_fin', $meeting->heure_fin ?? '') }}">
        @error('heure_fin') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Participants</label>
        @php
            $selectedParticipants = old('participant_ids', isset($meeting) ? $meeting->participants->pluck('id')->toArray() : []);
        @endphp
        <select name="participant_ids[]" class="form-select @error('participant_ids') is-invalid @enderror" multiple size="6">
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ in_array($user->id, $selectedParticipants) ? 'selected' : '' }}>
                    {{ $user->prenom }} {{ $user->nom }} ({{ $user->email }})
                </option>
            @endforeach
        </select>
        <small class="text-muted">Ctrl/Cmd pour sélectionner plusieurs participants.</small>
        @error('participant_ids') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Documents associés</label>
        @php
            $selectedDocuments = old('document_ids', isset($meeting) ? $meeting->documents->pluck('id')->toArray() : []);
        @endphp
        <select name="document_ids[]" class="form-select" multiple size="6">
            @foreach($documents as $document)
                <option value="{{ $document->id }}" {{ in_array($document->id, $selectedDocuments) ? 'selected' : '' }}>
                    {{ $document->titre }}
                </option>
            @endforeach
        </select>
        <small class="text-muted">Optionnel. Ctrl/Cmd pour sélectionner plusieurs documents.</small>
    </div>
</div>
<hr class="my-4">