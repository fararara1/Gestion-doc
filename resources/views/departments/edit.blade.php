@extends('layouts.app')

@section('content')

<div class="container">

<div class="card shadow">

<div class="card-header">

Modifier un département

</div>

<div class="card-body">

<form method="POST" action="{{ route('departments.update',$department) }}">

@csrf

@method('PUT')

@include('departments._form')

<button class="btn btn-success">

Modifier

</button>

<a href="{{ route('departments.index') }}" class="btn btn-secondary">

Retour

</a>

</form>

</div>

</div>

</div>

@endsection