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

    .btn-outline-gold {
        border: 1.5px solid var(--gold-400) !important;
        color: var(--gold-700) !important;
        border-radius: var(--radius-sm) !important;
        font-weight: 600;
        padding: 10px 20px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-outline-gold:hover {
        background: var(--gold-500) !important;
        color: var(--navy-900) !important;
        border-color: var(--gold-500) !important;
    }

    .form-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    .form-card .card-body {
        padding: 28px;
    }

    .form-label {
        font-weight: 600;
        font-size: 13px;
        color: var(--navy-700);
        margin-bottom: 8px;
    }

    .form-control,
    .form-select {
        border-radius: var(--radius-sm);
        border: 1px solid #e2e8f0;
        padding: 10px 14px;
        font-size: 14px;
        transition: var(--transition);
        background: #ffffff;
        font-family: 'Inter', sans-serif;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--gold-500);
        box-shadow: 0 0 0 3px rgba(234, 179, 8, 0.06);
        outline: none;
    }

    .form-control.is-invalid {
        border-color: #dc2626;
    }
</style>

<div class="page-header-custom">
    <h2><i class="bi bi-pencil-square"></i> Modifier le projet</h2>
    <a href="{{ route('projects.index') }}" class="btn-outline-gold">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
</div>

<div class="form-card">
    <div class="card-body">
        <form method="POST" action="{{ route('projects.update', $project) }}">
            @csrf
            @method('PUT')
            @include('projects._form', ['project' => $project])
            <div class="mt-4">
                <button type="submit" class="btn-gold-sm">
                    <i class="bi bi-check-lg"></i> Mettre à jour
                </button>
                <a href="{{ route('projects.index') }}" class="btn-outline-gold ms-2">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
