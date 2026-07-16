@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

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