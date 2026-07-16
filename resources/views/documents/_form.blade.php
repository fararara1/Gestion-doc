<div class="row g-3">
    <div class="col-md-12">
        <label class="form-label">Titre</label>
        <input type="text" name="titre" class="form-control @error('titre') is-invalid @enderror"
               value="{{ old('titre', $document->titre ?? '') }}">
        @error('titre') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-12">
        <label class="form-label">Description</label>
        <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $document->description ?? '') }}</textarea>
        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Projet</label>
        <select name="project_id" class="form-select @error('project_id') is-invalid @enderror">
            <option value="">-- Sélectionner --</option>
            @foreach($projects as $project)
                <option value="{{ $project->id }}" {{ old('project_id', $document->project_id ?? '') == $project->id ? 'selected' : '' }}>{{ $project->nom }}</option>
            @endforeach
        </select>
        @error('project_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Catégorie</label>
        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
            <option value="">-- Sélectionner --</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $document->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->nom }}</option>
            @endforeach
        </select>
        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Département</label>
        <select name="department_id" class="form-select @error('department_id') is-invalid @enderror">
            <option value="">-- Sélectionner --</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}" {{ old('department_id', $document->department_id ?? '') == $department->id ? 'selected' : '' }}>{{ $department->nom }}</option>
            @endforeach
        </select>
        @error('department_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-12">
        <label class="form-label">
            Fichier {{ isset($document) ? '(laisser vide pour conserver le fichier actuel)' : '' }}
        </label>
        <input type="file" name="fichier" class="form-control @error('fichier') is-invalid @enderror">
        @error('fichier') <div class="invalid-feedback">{{ $message }}</div> @enderror
        @if(isset($document))
            <small class="text-muted">Fichier actuel : {{ basename($document->fichier) }}</small>
        @endif
    </div>
</div>
<hr class="my-4">