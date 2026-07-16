<div class="mb-3">

    <label class="form-label">

        Nom du département

    </label>

    <input
        type="text"
        name="nom"
        class="form-control @error('nom') is-invalid @enderror"
        value="{{ old('nom',$department->nom ?? '') }}">

    @error('nom')

        <div class="invalid-feedback">

            {{ $message }}

        </div>

    @enderror

</div>