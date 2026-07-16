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
</div>
<hr class="my-4">