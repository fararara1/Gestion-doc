@extends('layouts.app')

@section('content')
<style>
    .page-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .page-header-custom h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--navy-900);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-header-custom h2 i {
        color: var(--gold-500);
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
    }

    .btn-gold-sm:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(234, 179, 8, 0.25);
        color: var(--navy-900);
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

    .card-footer-custom {
        background: #ffffff;
        border-top: 1px solid #f1f5f9;
        padding: 14px 24px;
    }
</style>

<div class="page-header-custom">
    <h2><i class="bi bi-tags"></i> Catégories</h2>
    <a href="{{ route('categories.create') }}" class="btn-gold-sm">
        <i class="bi bi-plus-lg"></i> Nouvelle catégorie
    </a>
</div>

<div class="data-table">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Documents liés</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td class="fw-semibold">{{ $category->nom }}</td>
                        <td>
                            <span class="badge-gold">{{ $category->documents_count }}</span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('categories.show', $category) }}" class="btn-icon btn-icon-info" title="Consulter">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('categories.edit', $category) }}" class="btn-icon btn-icon-warning" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression de cette catégorie ?');">
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
                        <td colspan="3" class="text-center py-4" style="color: var(--navy-600);">Aucune catégorie trouvée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer-custom">
        {{ $categories->links() }}
    </div>
</div>
@endsection
