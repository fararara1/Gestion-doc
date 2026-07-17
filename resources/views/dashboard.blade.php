@extends('layouts.app')

@section('content')

<style>
    /* ============================================
       DASHBOARD — STYLE GOLD / LUXE
       ============================================ */
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap');

    :root {
        --gold-50: #fefce8;
        --gold-100: #fef9c3;
        --gold-200: #fef08a;
        --gold-300: #fde047;
        --gold-400: #facc15;
        --gold-500: #eab308;
        --gold-600: #ca8a04;
        --gold-700: #a16207;
        --gold-800: #854d0e;
        --gold-900: #713f12;
        --navy-900: #0f172a;
        --navy-800: #1e293b;
        --navy-700: #334155;
        --navy-600: #475569;
        --navy-100: #f1f5f9;
        --navy-50: #f8fafc;
        --radius-xl: 20px;
        --radius-lg: 16px;
        --radius-md: 12px;
        --shadow-card: 0 1px 3px rgba(15, 23, 42, 0.04), 0 4px 12px rgba(15, 23, 42, 0.06);
        --shadow-elevated: 0 4px 12px rgba(15, 23, 42, 0.06), 0 12px 32px rgba(15, 23, 42, 0.1);
        --shadow-gold: 0 8px 24px rgba(234, 179, 8, 0.2);
    }

    body {
        background: var(--navy-50) !important;
    }

    /* ---------- EN-TÊTE HERO ---------- */
    .dashboard-hero {
        background: linear-gradient(135deg, var(--navy-900) 0%, var(--navy-800) 50%, var(--navy-700) 100%);
        border-radius: var(--radius-xl);
        padding: 2.5rem 2.75rem;
        position: relative;
        overflow: hidden;
        margin-bottom: 2.5rem;
        box-shadow: var(--shadow-elevated);
    }

    .dashboard-hero::before {
        content: '';
        position: absolute;
        top: -80px;
        right: -40px;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(234, 179, 8, 0.15) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .dashboard-hero::after {
        content: '';
        position: absolute;
        bottom: -100px;
        left: 20%;
        width: 240px;
        height: 240px;
        background: radial-gradient(circle, rgba(234, 179, 8, 0.08) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .dashboard-hero .hero-content {
        position: relative;
        z-index: 2;
    }

    .dashboard-hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2.25rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
    }

    .dashboard-hero .hero-subtitle {
        color: rgba(255, 255, 255, 0.65);
        font-size: 1rem;
        margin-bottom: 1.75rem;
        font-weight: 400;
    }

    .dashboard-hero .hero-subtitle strong {
        color: var(--gold-300);
        font-weight: 600;
    }

    .hero-role-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, var(--gold-500) 0%, var(--gold-400) 100%);
        color: var(--navy-900);
        font-size: 0.72rem;
        font-weight: 700;
        padding: 0.45em 1.1em;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-left: 0.75rem;
        vertical-align: middle;
        box-shadow: 0 4px 12px rgba(234, 179, 8, 0.3);
    }

    .hero-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-gold {
        background: linear-gradient(135deg, var(--gold-500) 0%, var(--gold-400) 100%) !important;
        color: var(--navy-900) !important;
        border: none !important;
        border-radius: 50px !important;
        padding: 0.75rem 1.75rem !important;
        font-weight: 700;
        font-size: 0.9rem;
        letter-spacing: 0.01em;
        transition: all 0.25s ease;
        box-shadow: var(--shadow-gold);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-gold:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(234, 179, 8, 0.35);
        color: var(--navy-900) !important;
    }

    .btn-ghost-gold {
        background: rgba(255, 255, 255, 0.06) !important;
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        border-radius: 50px !important;
        padding: 0.75rem 1.75rem !important;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-ghost-gold:hover {
        background: rgba(255, 255, 255, 0.12) !important;
        transform: translateY(-2px);
        color: #ffffff !important;
    }

    /* ---------- CARTES STATISTIQUES ---------- */
    .stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-xl) !important;
        padding: 1.75rem;
        box-shadow: var(--shadow-card);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--gold-500), var(--gold-300));
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .stat-card:hover::before {
        opacity: 1;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-elevated);
    }

    .stat-card .stat-icon-wrapper {
        width: 56px;
        height: 56px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1.25rem;
        position: relative;
    }

    .stat-card .stat-icon-wrapper::after {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: inherit;
        background: inherit;
        opacity: 0.25;
        filter: blur(8px);
    }

    .stat-card .stat-icon-wrapper i {
        position: relative;
        z-index: 2;
    }

    .stat-icon-gold { background: linear-gradient(135deg, #fef08a, #facc15); color: var(--gold-800); }
    .stat-icon-navy { background: linear-gradient(135deg, #cbd5e1, #94a3b8); color: var(--navy-800); }
    .stat-icon-emerald { background: linear-gradient(135deg, #a7f3d0, #34d399); color: #065f46; }
    .stat-icon-rose { background: linear-gradient(135deg, #fecaca, #f87171); color: #991b1b; }

    .stat-value {
        font-family: 'Playfair Display', serif;
        font-size: 2.25rem;
        font-weight: 700;
        color: var(--navy-900);
        line-height: 1;
        margin-bottom: 0.4rem;
        letter-spacing: -0.02em;
    }

    .stat-label {
        font-size: 0.8rem;
        color: var(--navy-600);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 0;
    }

    .stat-trend {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.78rem;
        font-weight: 600;
        margin-top: 0.75rem;
        padding: 4px 10px;
        border-radius: 20px;
    }

    .trend-up { background: #f0fdf4; color: #16a34a; }
    .trend-neutral { background: #fef9c3; color: #a16207; }

    /* ---------- CARTES LISTES ---------- */
    .content-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: var(--radius-xl) !important;
        box-shadow: var(--shadow-card);
        overflow: hidden;
        transition: box-shadow 0.3s ease;
    }

    .content-card:hover {
        box-shadow: var(--shadow-elevated);
    }

    .content-card .card-header-custom {
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        padding: 1.4rem 1.75rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .content-card .card-header-custom .card-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--navy-900);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .content-card .card-header-custom .card-title i {
        color: var(--gold-500);
        font-size: 1.25rem;
    }

    .content-card .card-body-custom {
        padding: 0.5rem 1.75rem 1.5rem;
    }

    .list-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 0.25rem;
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.2s ease;
        border-radius: 10px;
    }

    .list-item:last-child {
        border-bottom: none !important;
    }

    .list-item:hover {
        background: #fefce8;
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }

    .list-item .list-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        margin-right: 14px;
        flex-shrink: 0;
    }

    .list-icon-doc { background: linear-gradient(135deg, #fef9c3, #fde047); color: #854d0e; }
    .list-icon-meet { background: linear-gradient(135deg, #dbeafe, #93c5fd); color: #1e40af; }

    .list-item .list-title {
        font-weight: 600;
        font-size: 0.92rem;
        color: var(--navy-900);
        margin: 0;
        line-height: 1.3;
    }

    .list-item .list-meta {
        font-size: 0.78rem;
        color: var(--navy-600);
        margin-top: 2px;
    }

    .list-item .list-meta i {
        font-size: 0.7rem;
        margin-right: 3px;
    }

    .btn-outline-gold {
        border: 1.5px solid var(--gold-400) !important;
        color: var(--gold-700) !important;
        border-radius: 50px !important;
        font-size: 0.78rem;
        font-weight: 600;
        padding: 0.4rem 1.1rem;
        transition: all 0.2s ease;
    }

    .btn-outline-gold:hover {
        background: var(--gold-500) !important;
        color: var(--navy-900) !important;
        border-color: var(--gold-500) !important;
    }

    .btn-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 !important;
        border: 1.5px solid #e2e8f0 !important;
        color: var(--navy-600) !important;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-icon:hover {
        border-color: var(--gold-400) !important;
        color: var(--gold-700) !important;
        background: var(--gold-50) !important;
        transform: scale(1.05);
    }

    .btn-icon-success {
        border-color: #bbf7d0 !important;
        color: #16a34a !important;
    }

    .btn-icon-success:hover {
        background: #f0fdf4 !important;
        color: #15803d !important;
        border-color: #16a34a !important;
    }

    .empty-state {
        text-align: center;
        padding: 2.5rem 1rem;
        color: var(--navy-600);
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
    }

    /* ---------- SECTION DIVIDER ---------- */
    .section-divider {
        border: none;
        height: 1px;
        background: linear-gradient(90deg, transparent 0%, #e2e8f0 20%, #e2e8f0 80%, transparent 100%);
        margin: 1rem 0 2rem;
    }

    /* ---------- RESPONSIVE ---------- */
    @media (max-width: 992px) {
        .dashboard-hero {
            padding: 1.75rem 1.5rem;
        }
        .dashboard-hero h1 {
            font-size: 1.75rem;
        }
        .hero-actions {
            flex-direction: column;
            gap: 8px;
        }
        .btn-gold, .btn-ghost-gold {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .dashboard-hero h1 {
            font-size: 1.5rem;
        }
        .hero-role-badge {
            display: block;
            margin: 0.5rem 0 0;
        }
    }
</style>

<!-- Hero Section -->
<div class="dashboard-hero">
    <div class="hero-content">
        <h1>
            Tableau de bord
            <span class="hero-role-badge">
                <i class="bi bi-shield-check"></i>
                {{ ucfirst(Auth::user()->role) }}
            </span>
        </h1>
        <p class="hero-subtitle">
            Bienvenue, <strong>{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</strong>. Voici un aperçu de votre espace de travail.
        </p>
        <div class="hero-actions">
            <a href="{{ route('documents.create') }}" class="btn-gold">
                <i class="bi bi-plus-lg"></i> Nouveau document
            </a>
            <a href="{{ route('meetings.create') }}" class="btn-ghost-gold">
                <i class="bi bi-calendar-plus"></i> Nouvelle réunion
            </a>
        </div>
    </div>
</div>

<!-- Cartes statistiques -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-gold">
                <i class="bi bi-folder2-open"></i>
            </div>
            <div class="stat-label">Documents</div>
            <div class="stat-value">{{ $documentsCount ?? 0 }}</div>
            <span class="stat-trend trend-up">
                <i class="bi bi-arrow-up-short"></i> Actif
            </span>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-emerald">
                <i class="bi bi-calendar-event"></i>
            </div>
            <div class="stat-label">Réunions</div>
            <div class="stat-value">{{ $meetingsCount ?? 0 }}</div>
            <span class="stat-trend trend-up">
                <i class="bi bi-arrow-up-short"></i> Planifié
            </span>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-navy">
                <i class="bi bi-kanban"></i>
            </div>
            <div class="stat-label">Projets</div>
            <div class="stat-value">{{ $projectsCount ?? 0 }}</div>
            <span class="stat-trend trend-neutral">
                <i class="bi bi-dash-circle"></i> En cours
            </span>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-rose">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="stat-label">Utilisateurs</div>
            <div class="stat-value">{{ $usersCount ?? 0 }}</div>
            <span class="stat-trend trend-up">
                <i class="bi bi-arrow-up-short"></i> Inscrits
            </span>
        </div>
    </div>
</div>

<!-- Deux colonnes -->
<div class="row g-4">
    <!-- Documents récents -->
    <div class="col-lg-6">
        <div class="content-card">
            <div class="card-header-custom">
                <span class="card-title">
                    <i class="bi bi-file-earmark-text"></i>
                    Documents récents
                </span>
                <a href="{{ route('documents.index') }}" class="btn-outline-gold">
                    Voir tout <i class="bi bi-arrow-right-short"></i>
                </a>
            </div>
            <div class="card-body-custom">
                @forelse($recentDocuments ?? [] as $document)
                    <div class="list-item">
                        <div class="d-flex align-items-center">
                            <div class="list-icon list-icon-doc">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                            <div>
                                <a href="{{ route('documents.show', $document) }}" class="list-title text-decoration-none">
                                    {{ $document->titre }}
                                </a>
                                <div class="list-meta">
                                    {{ $document->user?->prenom }} {{ $document->user?->nom }} •
                                    {{ $document->created_at->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('documents.download', $document) }}" class="btn-icon btn-icon-success" title="Télécharger">
                            <i class="bi bi-download"></i>
                        </a>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <p>Aucun document disponible.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Prochaines réunions -->
    <div class="col-lg-6">
        <div class="content-card">
            <div class="card-header-custom">
                <span class="card-title">
                    <i class="bi bi-calendar-check"></i>
                    Prochaines réunions
                </span>
                <a href="{{ route('meetings.index') }}" class="btn-outline-gold">
                    Voir tout <i class="bi bi-arrow-right-short"></i>
                </a>
            </div>
            <div class="card-body-custom">
                @forelse($upcomingMeetings ?? [] as $meeting)
                    <div class="list-item">
                        <div class="d-flex align-items-center">
                            <div class="list-icon list-icon-meet">
                                <i class="bi bi-calendar-event"></i>
                            </div>
                            <div>
                                <a href="{{ route('meetings.show', $meeting) }}" class="list-title text-decoration-none">
                                    {{ $meeting->titre }}
                                </a>
                                <div class="list-meta">
                                    <i class="bi bi-calendar"></i>
                                    {{ \Carbon\Carbon::parse($meeting->date)->format('d/m/Y') }}
                                    <span class="mx-1">•</span>
                                    <i class="bi bi-clock"></i>
                                    {{ \Carbon\Carbon::parse($meeting->heure_debut)->format('H:i') }}
                                    -
                                    {{ \Carbon\Carbon::parse($meeting->heure_fin)->format('H:i') }}
                                </div>
                                <div class="list-meta">
                                    <i class="bi bi-people"></i>
                                    {{ $meeting->participants->count() }} participant(s)
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('meetings.ics', $meeting) }}" class="btn-icon" title="Télécharger ICS">
                            <i class="bi bi-calendar-event"></i>
                        </a>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="bi bi-calendar-x"></i>
                        <p>Aucune réunion programmée.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
