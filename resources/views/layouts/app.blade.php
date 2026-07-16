<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Gestion Documentaire') }}</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        /* =========================
   GOOGLE FONT
========================= */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:#f1f5f9;
    color:#374151;
}

/* =========================
        SIDEBAR
========================= */

.sidebar{
    width:270px;
    min-height:100vh;
    background:linear-gradient(180deg,#0f172a,#1e3a8a);
    color:white;
    position:sticky;
    top:0;
    box-shadow:8px 0 30px rgba(0,0,0,.08);
}

.sidebar a{
    text-decoration:none;
}

.sidebar .fs-5{
    font-weight:700;
    letter-spacing:1px;
}

.sidebar hr{
    opacity:.15;
}

.sidebar .nav-link{
    color:#cbd5e1;
    border-radius:14px;
    padding:12px 16px;
    margin-bottom:8px;
    transition:.35s;
    font-weight:500;
}

.sidebar .nav-link i{
    width:24px;
    margin-right:8px;
    font-size:18px;
}

.sidebar .nav-link:hover{

    background:rgba(255,255,255,.12);

    color:white;

    transform:translateX(6px);
}

.sidebar .nav-link.active{

    background:white;

    color:#1d4ed8;

    font-weight:600;

    box-shadow:0 10px 20px rgba(0,0,0,.12);
}

/* =========================
      CONTENU
========================= */

.flex-grow-1{

    padding:35px;

    background:#f8fafc;
}

/* =========================
      CARD
========================= */

.card{

    border:none;

    border-radius:20px;

    box-shadow:0 10px 35px rgba(15,23,42,.08);

    transition:.3s;

    overflow:hidden;

    background:white;
}

.card:hover{

    transform:translateY(-6px);

    box-shadow:0 20px 45px rgba(15,23,42,.12);
}

.card-header{

    background:white;

    border-bottom:1px solid #eef2f7;

    font-size:20px;

    font-weight:600;

    color:#1e293b;
}

/* =========================
      TABLES
========================= */

.table{

    border-radius:15px;

    overflow:hidden;

    background:white;
}

.table thead{

    background:#2563eb;

    color:white;
}

.table thead th{

    border:none;

    font-weight:600;

    padding:15px;
}

.table td{

    padding:15px;

    vertical-align:middle;
}

.table tbody tr{

    transition:.25s;
}

.table tbody tr:hover{

    background:#eff6ff;
}

/* =========================
      BUTTONS
========================= */

.btn{

    border-radius:12px;

    padding:10px 20px;

    font-weight:500;

    transition:.3s;
}

.btn-primary{

    background:#2563eb;

    border:none;
}

.btn-primary:hover{

    background:#1d4ed8;

    transform:translateY(-2px);
}

.btn-success{

    background:#16a34a;

    border:none;
}

.btn-success:hover{

    background:#15803d;

    transform:translateY(-2px);
}

.btn-danger{

    border:none;

    background:#dc2626;
}

.btn-danger:hover{

    background:#b91c1c;

    transform:translateY(-2px);
}

.btn-warning{

    border:none;

    color:white;

    background:#f59e0b;
}

.btn-warning:hover{

    background:#d97706;
}

/* =========================
      FORM
========================= */

.form-control,
.form-select{

    border-radius:12px;

    border:1px solid #dbe4ef;

    padding:12px 15px;

    transition:.3s;
}

.form-control:focus,
.form-select:focus{

    border-color:#2563eb;

    box-shadow:0 0 0 .2rem rgba(37,99,235,.15);
}

/* =========================
      ALERTS
========================= */

.alert{

    border:none;

    border-radius:15px;

    box-shadow:0 8px 20px rgba(0,0,0,.05);
}

/* =========================
      BADGES
========================= */

.badge{

    padding:8px 12px;

    border-radius:50px;

    font-weight:500;
}

/* =========================
      PAGINATION
========================= */

.pagination .page-link{

    border:none;

    margin:0 3px;

    border-radius:10px;

    color:#2563eb;
}

.pagination .active .page-link{

    background:#2563eb;

    border:none;
}

/* =========================
      TITRES
========================= */

h1,h2,h3,h4,h5{

    color:#1e293b;

    font-weight:700;
}

/* =========================
      SCROLLBAR
========================= */

::-webkit-scrollbar{

    width:10px;
}

::-webkit-scrollbar-track{

    background:#e5e7eb;
}

::-webkit-scrollbar-thumb{

    background:#2563eb;

    border-radius:20px;
}

::-webkit-scrollbar-thumb:hover{

    background:#1d4ed8;
}

/* =========================
      ANIMATION
========================= */

.card,
.table,
.alert{

    animation:fade .5s ease;
}

@keyframes fade{

    from{

        opacity:0;

        transform:translateY(20px);
    }

    to{

        opacity:1;

        transform:translateY(0);
    }
}
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Menu latéral -->
        <nav class="sidebar d-flex flex-column p-3" style="width: 250px;">
            <a href="{{ route('dashboard') }}" class="d-flex align-items-center mb-3 text-white text-decoration-none">
                <i class="bi bi-folder2-open fs-4 me-2"></i>
                <span class="fs-5 fw-bold">GestDoc</span>
            </a>
            <hr class="text-secondary">
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>

                @auth
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                                <i class="bi bi-people"></i> Utilisateurs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('departments.index') }}" class="nav-link {{ request()->routeIs('departments.*') ? 'active' : '' }}">
                                <i class="bi bi-building"></i> Départements
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('projects.index') }}" class="nav-link {{ request()->routeIs('projects.*') ? 'active' : '' }}">
                                <i class="bi bi-kanban"></i> Projets
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                                <i class="bi bi-tags"></i> Catégories
                            </a>
                        </li>
                    @endif
                @endauth

                <li class="nav-item">
                    <a href="{{ route('documents.index') }}" class="nav-link {{ request()->routeIs('documents.*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-text"></i> Documents
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('meetings.index') }}" class="nav-link {{ request()->routeIs('meetings.*') ? 'active' : '' }}">
                        <i class="bi bi-calendar-event"></i> Réunions
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <i class="bi bi-person-circle"></i> Profil
                    </a>
                </li>
            </ul>
            <hr class="text-secondary">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link btn btn-link w-100 text-start">
                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                </button>
            </form>
        </nav>

        <!-- Contenu principal -->
        <div class="flex-grow-1 p-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>