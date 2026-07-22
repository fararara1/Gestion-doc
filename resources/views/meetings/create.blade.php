@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title"><i class="bi bi-calendar-plus"></i> Nouvelle réunion</h1>
        <p class="page-subtitle">Planifier une réunion</p>
    </div>
    <a href="{{ route('meetings.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('meetings.store') }}">
            @csrf
            @include('meetings._form', ['meeting' => null])
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> Créer la réunion
                </button>
                <a href="{{ route('meetings.index') }}" class="btn btn-outline-secondary ms-2">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection

