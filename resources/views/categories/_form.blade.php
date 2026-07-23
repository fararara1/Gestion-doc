<div class="row g-3">
    <div class="col-md-12">
        <label class="form-label">Nom de la catégorie</label>
        <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror"
               value="{{ old('nom', $category->nom ?? '') }}">
        @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
<hr class="my-4">
