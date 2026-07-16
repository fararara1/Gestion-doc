@extends('layouts.app')

@section('content')
<h2 class="mb-4"><i class="bi bi-pencil-square"></i> Modifier la réunion</h2>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('meetings.update', $meeting) }}">
            @csrf
            @method('PUT')
            @include('meetings._form', ['meeting' => $meeting])
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg"></i> Mettre à jour
            </button>
            <a href="{{ route('meetings.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
@endsection