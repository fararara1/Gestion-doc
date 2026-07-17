@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-bell"></i> Mes notifications</h2>
</div>

<div class="card">
    <div class="card-body">
        @forelse(auth()->user()->notifications as $notification)
            <div class="border-bottom py-3 {{ $notification->read_at ? '' : 'bg-light' }}">
                <p class="mb-1">{{ $notification->data['message'] ?? json_encode($notification->data) }}</p>
                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
            </div>
        @empty
            <p class="text-muted">Aucune notification pour le moment.</p>
        @endforelse
    </div>
</div>
@endsection
