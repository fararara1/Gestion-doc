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
        <input type="file" name="fichier" class="form-control @error('fichier') is-invalid @enderror"
               onchange="previewFile(this)">
        @error('fichier') <div class="invalid-feedback">{{ $message }}</div> @enderror
        @if(isset($document) && $document->fichier)
            <div class="mt-2 d-flex align-items-center gap-2">
                <i class="bi bi-file-earmark-text" style="color: var(--gold-600);"></i>
                <small class="text-navy-600">Fichier actuel : {{ basename($document->fichier) }}</small>
                <a href="{{ route('documents.download', $document) }}" class="btn btn-sm btn-success btn-icon">
                    <i class="bi bi-download"></i>
                </a>
            </div>
        @endif
        <div id="filePreview" class="mt-2"></div>
    </div>
</div>
<hr class="my-4">

<script>
function previewFile(input) {
    const preview = document.getElementById('filePreview');
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<div class="alert alert-info"><i class="bi bi-file-earmark-check"></i> Fichier sélectionné : <strong>' + file.name + '</strong> (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)</div>';
        };
        reader.readAsDataURL(file);
    }
}
</script>
