@extends('layouts.app')

@section('content')
<h2 class="mb-4"><i class="bi bi-calendar-plus"></i> Nouvelle réunion</h2>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('meetings.store') }}">
            @csrf
            @include('meetings._form', ['meeting' => null])
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg"></i> Créer la réunion
            </button>
            <a href="{{ route('meetings.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
@endsection