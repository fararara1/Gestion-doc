<div class="row g-3">
    <div class="col-md-12">
        <label class="form-label">Nom du projet</label>
        <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror"
               value="{{ old('nom', $project->nom ?? '') }}">
        @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-12">
        <label class="form-label">Description</label>
        <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $project->description ?? '') }}</textarea>
        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Date de début</label>
        <input type="date" name="date_debut" class="form-control @error('date_debut') is-invalid @enderror"
               value="{{ old('date_debut', $project->date_debut ?? '') }}">
        @error('date_debut') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Date de fin</label>
        <input type="date" name="date_fin" class="form-control @error('date_fin') is-invalid @enderror"
               value="{{ old('date_fin', $project->date_fin ?? '') }}">
        @error('date_fin') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Statut</label>
        <select name="statut" class="form-select @error('statut') is-invalid @enderror">
            <option value="">-- Sélectionner --</option>
            <option value="En attente" {{ old('statut', $project->statut ?? '') == 'En attente' ? 'selected' : '' }}>En attente</option>
            <option value="En cours" {{ old('statut', $project->statut ?? '') == 'En cours' ? 'selected' : '' }}>En cours</option>
            <option value="Terminé" {{ old('statut', $project->statut ?? '') == 'Terminé' ? 'selected' : '' }}>Terminé</option>
        </select>
        @error('statut') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-12">
        <label class="form-label">Département</label>
        <select name="department_id" class="form-select @error('department_id') is-invalid @enderror">
            <option value="">-- Sélectionner --</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}" {{ old('department_id', $project->department_id ?? '') == $department->id ? 'selected' : '' }}>
                    {{ $department->nom }}
                </option>
            @endforeach
        </select>
        @error('department_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
<hr class="my-4">
