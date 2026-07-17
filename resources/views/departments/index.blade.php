@extends('layouts.app')

@section('content')
<style>
    .page-header-custom {
        background: linear-gradient(135deg, var(--navy-900) 0%, var(--navy-800) 50%, var(--navy-700) 100%);
        border-radius: var(--radius-xl);
        padding: 2rem 2.25rem;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .page-header-custom::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -40px;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(234, 179, 8, 0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .page-header-custom h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        font-weight: 700;
        color: #ffffff;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
        position: relative;
        z-index: 2;
    }

    .page-header-custom h3 i {
        color: var(--gold-400);
    }

    .page-header-custom small {
        color: rgba(255, 255, 255, 0.65);
        position: relative;
        z-index: 2;
    }

    .btn-gold-sm {
        background: linear-gradient(135deg, var(--gold-500) 0%, var(--gold-400) 100%);
        color: var(--navy-900);
        border: none;
        border-radius: var(--radius-sm);
        padding: 10px 20px;
        font-weight: 700;
        font-size: 0.9rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        position: relative;
        z-index: 2;
        text-decoration: none;
    }

    .btn-gold-sm:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(234, 179, 8, 0.25);
        color: var(--navy-900);
    }

    .search-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-xl);
        padding: 20px 24px;
        box-shadow: var(--shadow-sm);
        margin-bottom: 20px;
    }

    .search-card .form-control {
        border-radius: var(--radius-sm);
        border: 1px solid #e2e8f0;
        padding: 10px 14px;
        font-size: 14px;
        transition: var(--transition);
        background: #ffffff;
        font-family: 'Inter', sans-serif;
    }

    .search-card .form-control:focus {
        border-color: var(--gold-500);
        box-shadow: 0 0 0 3px rgba(234, 179, 8, 0.06);
        outline: none;
    }

    .search-card .input-group-text {
        background: var(--navy-50);
        border: 1px solid #e2e8f0;
        color: var(--navy-600);
        border-radius: var(--radius-sm) 0 0 var(--radius-sm);
    }

    .data-table {
        border-radius: var(--radius-xl);
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        box-shadow: var(--shadow-sm);
    }

    .data-table thead {
        background: var(--navy-900);
        color: #f1f5f9;
    }

    .data-table thead th {
        border: none;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 16px;
        font-family: 'Inter', sans-serif;
    }

    .data-table tbody td {
        padding: 15px 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
    }

    .data-table tbody tr {
        transition: var(--transition);
    }

    .data-table tbody tr:hover {
        background: var(--gold-50);
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    .badge-gold {
        background: linear-gradient(135deg, var(--gold-500) 0%, var(--gold-400) 100%);
        color: var(--navy-900);
        font-weight: 700;
        padding: 0.4em 0.9em;
        border-radius: 50px;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 !important;
        border: 1.5px solid #e2e8f0 !important;
        color: var(--navy-600) !important;
        transition: var(--transition);
        text-decoration: none;
        margin-right: 4px;
    }

    .btn-icon:hover {
        border-color: var(--gold-400) !important;
        color: var(--gold-700) !important;
        background: var(--gold-50) !important;
        transform: scale(1.05);
    }

    .btn-icon-warning { border-color: #fde68a !important; color: #d97706 !important; }
    .btn-icon-warning:hover { background: #fffbeb !important; color: #a16207 !important; border-color: #d97706 !important; }

    .btn-icon-danger { border-color: #fecaca !important; color: #dc2626 !important; }
    .btn-icon-danger:hover { background: #fef2f2 !important; color: #991b1b !important; border-color: #dc2626 !important; }

    .btn-icon-info { border-color: #bfdbfe !important; color: #2563eb !important; }
    .btn-icon-info:hover { background: #eff6ff !important; color: #1e40af !important; border-color: #2563eb !important; }

    .empty-state {
        text-align: center;
        padding: 2.5rem 1rem;
    }

    .empty-state i {
        font-size: 2.5rem;
        color: var(--gold-300);
        margin-bottom: 0.75rem;
        display: block;
    }

    .empty-state p {
        margin: 0;
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--navy-600);
    }
</style>

<div class="page-header-custom d-flex justify-content-between align-items-center">
    <div>
        <h3><i class="bi bi-building"></i> Gestion des départements</h3>
        <small>Gérez les services de votre entreprise.</small>
    </div>
    <a href="{{ route('departments.create') }}" class="btn-gold-sm">
        <i class="bi bi-plus-circle"></i> Nouveau département
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success" style="border-radius: var(--radius-sm); margin-bottom: 20px; background: #fefce8; border-left: 4px solid var(--gold-500); color: var(--gold-700);">
        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
    </div>
@endif

<div class="search-card">
    <form id="searchForm" method="GET" action="{{ route('departments.index') }}" class="mb-0">
        <div class="input-group" style="max-width: 400px;">
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
    function liveSearch() {
        clearTimeout(timer);
        timer = setTimeout(function() {
            document.getElementById('searchForm').submit();
        }, 300);
    }
    </script>
</div>

<div class="data-table">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
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
                            <span class="badge-gold">{{ $loop->iteration }}</span>
                        </td>
                        <td class="fw-semibold">{{ $department->nom }}</td>
                        <td>{{ $department->created_at->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <a href="{{ route('departments.show', $department) }}" class="btn-icon btn-icon-info" title="Consulter">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('departments.edit', $department) }}" class="btn-icon btn-icon-warning" title="Modifier">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('departments.destroy', $department) }}" method="POST" class="d-inline" onsubmit="return confirm('Voulez-vous vraiment supprimer ce département ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon btn-icon-danger" title="Supprimer">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="empty-state">
                                <i class="bi bi-building"></i>
                                <h5 class="mt-3" style="color: var(--navy-900);">Aucun département trouvé</h5>
                                <p>Cliquez sur <strong>Nouveau département</strong> pour commencer.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end mt-3" style="padding: 0 24px 16px;">
        {{ $departments->links() }}
    </div>
</div>
@endsection
