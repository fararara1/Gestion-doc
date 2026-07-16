@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">
    <style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

:root{
    --primary:#2563eb;
    --primary-dark:#1d4ed8;
    --secondary:#64748b;
    --success:#16a34a;
    --warning:#f59e0b;
    --danger:#dc2626;
    --purple:#7c3aed;
    --cyan:#06b6d4;

    --bg:#f4f7fb;
    --white:#ffffff;
    --text:#1e293b;
    --text-light:#64748b;
    --border:#e5e7eb;

    --radius:18px;
    --transition:.35s;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:var(--bg);
    color:var(--text);
}

/*============================
            CARDS
============================*/

.card{

    border:none;

    border-radius:var(--radius);

    background:var(--white);

    box-shadow:0 12px 35px rgba(0,0,0,.06);

    transition:var(--transition);

    overflow:hidden;

}

.card:hover{

    transform:translateY(-6px);

    box-shadow:0 20px 45px rgba(37,99,235,.15);

}

.card-header{

    background:white;

    border-bottom:1px solid var(--border);

    font-weight:600;

    font-size:18px;

    color:var(--text);

}

/*============================
          STAT CARDS
============================*/

.stat-card{

    border-radius:22px;

    padding:28px;

    background:white;

    display:flex;

    align-items:center;

    justify-content:space-between;

    box-shadow:0 15px 35px rgba(0,0,0,.05);

    transition:.3s;

}

.stat-card:hover{

    transform:translateY(-7px);

}

.stat-icon{

    width:70px;

    height:70px;

    border-radius:18px;

    display:flex;

    align-items:center;

    justify-content:center;

    color:white;

    font-size:32px;

}

.bg-blue{

    background:linear-gradient(135deg,#2563eb,#60a5fa);

}

.bg-green{

    background:linear-gradient(135deg,#16a34a,#4ade80);

}

.bg-orange{

    background:linear-gradient(135deg,#f59e0b,#fbbf24);

}

.bg-red{

    background:linear-gradient(135deg,#dc2626,#ef4444);

}

.bg-purple{

    background:linear-gradient(135deg,#7c3aed,#a855f7);

}

.bg-cyan{

    background:linear-gradient(135deg,#0891b2,#22d3ee);

}

.stat-title{

    color:var(--text-light);

    font-size:15px;

}

.stat-number{

    font-size:34px;

    font-weight:700;

    color:var(--text);

}

.stat-sub{

    font-size:13px;

    color:#94a3b8;

}

/*============================
            BUTTONS
============================*/

.btn{

    border-radius:12px;

    padding:10px 22px;

    font-weight:500;

    transition:.3s;

    border:none;

}

.btn-primary{

    background:linear-gradient(135deg,#2563eb,#3b82f6);

}

.btn-primary:hover{

    transform:translateY(-2px);

    box-shadow:0 10px 25px rgba(37,99,235,.3);

}

.btn-success{

    background:linear-gradient(135deg,#16a34a,#22c55e);

}

.btn-warning{

    background:linear-gradient(135deg,#f59e0b,#fbbf24);

    color:white;

}

.btn-danger{

    background:linear-gradient(135deg,#dc2626,#ef4444);

}

.btn-secondary{

    background:#64748b;

}

/*============================
          TABLES
============================*/

.table{

    border-radius:18px;

    overflow:hidden;

    background:white;

}

.table thead{

    background:#2563eb;

    color:white;

}

.table th{

    border:none;

    padding:18px;

}

.table td{

    padding:18px;

    vertical-align:middle;

}

.table tbody tr{

    transition:.3s;

}

.table tbody tr:hover{

    background:#eff6ff;

}

/*============================
            FORM
============================*/

.form-control,
.form-select{

    border-radius:14px;

    border:1px solid #dbe4ef;

    padding:12px 15px;

    transition:.3s;

}

.form-control:focus,
.form-select:focus{

    border-color:#3b82f6;

    box-shadow:0 0 0 .2rem rgba(59,130,246,.15);

}

/*============================
          BADGES
============================*/

.badge{

    border-radius:30px;

    padding:8px 15px;

    font-size:13px;

}

/*============================
        DASHBOARD TITLE
============================*/

.page-title{

    font-size:32px;

    font-weight:700;

    color:#1e293b;

}

.page-subtitle{

    color:#64748b;

}

/*============================
        LISTS
============================*/

.activity-item{

    display:flex;

    align-items:center;

    justify-content:space-between;

    padding:15px 0;

    border-bottom:1px solid #edf2f7;

}

.activity-item:last-child{

    border:none;

}

.activity-icon{

    width:45px;

    height:45px;

    border-radius:50%;

    display:flex;

    align-items:center;

    justify-content:center;

    color:white;

}

/*============================
          ALERTS
============================*/

.alert{

    border:none;

    border-radius:15px;

}

/*============================
        SCROLLBAR
============================*/

::-webkit-scrollbar{

    width:9px;

}

::-webkit-scrollbar-thumb{

    background:#3b82f6;

    border-radius:20px;

}

/*============================
        ANIMATION
============================*/

.fade-up{

    animation:fadeUp .6s ease;

}

@keyframes fadeUp{

from{

opacity:0;

transform:translateY(20px);

}

to{

opacity:1;

transform:translateY(0);

}

}

/*============================
        RESPONSIVE
============================*/

@media(max-width:992px){

.stat-card{

margin-bottom:20px;

}

.page-title{

font-size:25px;

}

}</style>
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Tableau de bord</h2>
            <p class="text-muted mb-0">
                Bienvenue,
                <strong>{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</strong>
            </p>
        </div>

        <div>
            <span class="badge bg-primary fs-6 px-3 py-2">
                {{ ucfirst(Auth::user()->role) }}
            </span>
        </div>
    </div>

    <!-- Cartes statistiques -->
    <div class="row g-4 mb-4">

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary rounded-circle p-3 me-3">
                        <i class="bi bi-folder2-open text-white fs-3"></i>
                    </div>

                    <div>
                        <small class="text-muted">Documents</small>
                        <h3 class="fw-bold mb-0">{{ $documentsCount ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success rounded-circle p-3 me-3">
                        <i class="bi bi-calendar-event text-white fs-3"></i>
                    </div>

                    <div>
                        <small class="text-muted">Réunions</small>
                        <h3 class="fw-bold mb-0">{{ $meetingsCount ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-warning rounded-circle p-3 me-3">
                        <i class="bi bi-kanban text-white fs-3"></i>
                    </div>

                    <div>
                        <small class="text-muted">Projets</small>
                        <h3 class="fw-bold mb-0">{{ $projectsCount ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-danger rounded-circle p-3 me-3">
                        <i class="bi bi-people-fill text-white fs-3"></i>
                    </div>

                    <div>
                        <small class="text-muted">Utilisateurs</small>
                        <h3 class="fw-bold mb-0">{{ $usersCount ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Deux colonnes -->
    <div class="row g-4">

        <!-- Documents -->
        <div class="col-lg-6">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white fw-bold">
                    <i class="bi bi-file-earmark-text text-primary"></i>
                    Documents récents
                </div>

                <div class="card-body">

                    @forelse($recentDocuments ?? [] as $document)

                        <div class="d-flex justify-content-between border-bottom py-2">

                            <div>

                                <strong>{{ $document->titre }}</strong>

                                <br>

                                <small class="text-muted">
                                    {{ $document->created_at->format('d/m/Y') }}
                                </small>

                            </div>

                            <i class="bi bi-file-earmark fs-4 text-secondary"></i>

                        </div>

                    @empty

                        <p class="text-muted text-center py-3">
                            Aucun document disponible.
                        </p>

                    @endforelse

                </div>

            </div>

        </div>

        <!-- Réunions -->
        <div class="col-lg-6">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white fw-bold">
                    <i class="bi bi-calendar-check text-success"></i>
                    Prochaines réunions
                </div>

                <div class="card-body">

                    @forelse($upcomingMeetings ?? [] as $meeting)

                        <div class="border-bottom py-2">

                            <strong>{{ $meeting->titre }}</strong>

                            <br>

                            <small class="text-muted">

                                {{ \Carbon\Carbon::parse($meeting->date)->format('d/m/Y') }}

                                •

                                {{ $meeting->heure_debut }}

                            </small>

                        </div>

                    @empty

                        <p class="text-muted text-center py-3">
                            Aucune réunion programmée.
                        </p>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

    
            </div>

        </div>

    </div>

</div>

@endsection