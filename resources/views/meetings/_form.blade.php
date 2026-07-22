<div class="row g-3">
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
        .item-icon {
            color: var(--gold-600);
            font-size: 1.1rem;
            flex-shrink: 0;
            margin-top: 1px;
        }
    </style>
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
               value="{{ old('heure_debut', isset($meeting) ? $meeting->heure_debut->format('H:i') : '') }}">
        @error('heure_debut') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Heure de fin</label>
        <input type="time" name="heure_fin" class="form-control @error('heure_fin') is-invalid @enderror"
               value="{{ old('heure_fin', isset($meeting) ? $meeting->heure_fin->format('H:i') : '') }}">
        @error('heure_fin') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Participants</label>
        @php
            $selectedParticipants = old('participant_ids', isset($meeting) ? $meeting->participants->pluck('id')->toArray() : []);
        @endphp
        <div class="checkbox-list">
            @foreach($users as $user)
                <div class="checkbox-item">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="participant_ids[]" value="{{ $user->id }}" id="participant_{{ $user->id }}" {{ in_array($user->id, $selectedParticipants) ? 'checked' : '' }}>
                        <label class="form-check-label" for="participant_{{ $user->id }}">
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
            @endforeach
        </div>
        <small class="text-navy-600">Cochez un ou plusieurs participants.</small>
        @error('participant_ids') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Documents associés</label>
        @php
            $selectedDocuments = old('document_ids', isset($meeting) ? $meeting->documents->pluck('id')->toArray() : []);
        @endphp
        <div class="checkbox-list">
            @foreach($documents as $document)
                <div class="checkbox-item">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="document_ids[]" value="{{ $document->id }}" id="document_{{ $document->id }}" {{ in_array($document->id, $selectedDocuments) ? 'checked' : '' }}>
                        <label class="form-check-label" for="document_{{ $document->id }}">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-file-earmark-text item-icon"></i>
                                <div class="item-primary">{{ $document->titre }}</div>
                            </div>
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
        <small class="text-navy-600">Optionnel. Cochez un ou plusieurs documents.</small>
    </div>
</div>
<hr class="my-4">
