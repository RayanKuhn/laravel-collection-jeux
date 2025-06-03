@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
    <div class="text-center">
        <h1 class="display-4 mb-4">Bienvenue Rayan, gros bg va 🎮</h1>
        <p class="lead">Gère ta collection de jeux avec classe, style et puissance Laravel.</p>
        <a href="{{ route('games.index') }}" class="btn btn-primary">Voir mes jeux</a>
    </div>
@endsection
