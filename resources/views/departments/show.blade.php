@extends('layouts.app')

@section('content')

<div class="container">

<div class="card shadow">

<div class="card-header">

Détails du département

</div>

<div class="card-body">

<h4>{{ $department->nom }}</h4>

</div>

</div>

</div>

@endsection