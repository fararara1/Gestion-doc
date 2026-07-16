@extends('layouts.app')

@section('content')

<div class="container">

<div class="card shadow">

<div class="card-header">

Ajouter un département

</div>

<div class="card-body">

<form method="POST" action="{{ route('departments.store') }}">

@csrf

@include('departments._form')

<button class="btn btn-primary">

Enregistrer

</button>

<a href="{{ route('departments.index') }}" class="btn btn-secondary">

Retour

</a>

</form>

</div>

</div>

</div>

@endsection