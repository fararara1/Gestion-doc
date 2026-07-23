<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Nom</label>
        <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror"
               value="{{ old('nom', $user->nom ?? '') }}">
        @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Prénom</label>
        <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror"
               value="{{ old('prenom', $user->prenom ?? '') }}">
        @error('prenom') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Email professionnel</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $user->email ?? '') }}">
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Service</label>
        <select name="department_id" class="form-select @error('department_id') is-invalid @enderror">
            <option value="">-- Sélectionner --</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}"
                    {{ old('department_id', $user->department_id ?? '') == $department->id ? 'selected' : '' }}>
                    {{ $department->nom }}
                </option>
            @endforeach
        </select>
        @error('department_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Rôle</label>
        <select name="role" class="form-select @error('role') is-invalid @enderror">
            <option value="collaborateur" {{ old('role', $user->role ?? '') == 'collaborateur' ? 'selected' : '' }}>Collaborateur</option>
            <option value="administrateur" {{ old('role', $user->role ?? '') == 'administrateur' ? 'selected' : '' }}>Administrateur</option>
        </select>
        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Mot de passe {{ isset($user) ? '(laisser vide pour ne pas changer)' : '' }}</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Confirmer le mot de passe</label>
        <input type="password" name="password_confirmation" class="form-control">
    </div>
</div>
<hr class="my-4">
