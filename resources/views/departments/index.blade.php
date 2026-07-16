@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="card border-0 shadow">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div>
                <h3 class="mb-0 fw-bold">
                    <i class="bi bi-building text-primary"></i>
                    Gestion des départements
                </h3>
                <small class="text-muted">
                    Gérez les services de votre entreprise.
                </small>
            </div>

            <a href="{{ route('departments.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i>
                Nouveau département
            </a>

        </div>

        <div class="card-body">

            @if(session('success'))

                <div class="alert alert-success alert-dismissible fade show">

                    <i class="bi bi-check-circle"></i>

                    {{ session('success') }}

                    <button class="btn-close" data-bs-dismiss="alert"></button>

                </div>

            @endif

            <form id="searchForm" method="GET" action="{{ route('departments.index') }}" class="mb-4">

    <div class="input-group">

        <span class="input-group-text">
            <i class="bi bi-search"></i>
        </span>

        <input
            type="text"
            name="search"
            id="search"
            class="form-control"
            placeholder="Rechercher un département..."
            value="{{ request('search') }}"
            onkeyup="liveSearch()">


                 

    </div>

</form>

<script>
let timer;

function liveSearch(){

    clearTimeout(timer);

    timer = setTimeout(function(){

        document.getElementById('searchForm').submit();

    },300);

}
</script>

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Nom du département</th>

                            <th>Créé le</th>

                            <th class="text-center">Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($departments as $department)

                        <tr>

                            <td>

                                <span class="badge bg-secondary">

                                    {{ $loop->iteration }}

                                </span>

                            </td>

                            <td class="fw-semibold">

                                {{ $department->nom }}

                            </td>

                            <td>

                                {{ $department->created_at->format('d/m/Y') }}

                            </td>

                            <td class="text-center">

                                <a href="{{ route('departments.show',$department) }}"
                                   class="btn btn-outline-info btn-sm">

                                    <i class="bi bi-eye"></i>

                                </a>

                                <a href="{{ route('departments.edit',$department) }}"
                                   class="btn btn-outline-warning btn-sm">

                                    <i class="bi bi-pencil-square"></i>

                                </a>

                                <form action="{{ route('departments.destroy',$department) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Voulez-vous vraiment supprimer ce département ?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-outline-danger btn-sm">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="4" class="text-center py-5">

                                <i class="bi bi-building fs-1 text-secondary"></i>

                                <h5 class="mt-3">

                                    Aucun département trouvé

                                </h5>

                                <p class="text-muted">

                                    Cliquez sur <strong>Nouveau département</strong> pour commencer.

                                </p>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="d-flex justify-content-end mt-3">

                {{ $departments->links() }}

            </div>

        </div>

    </div>

</div>

@endsection