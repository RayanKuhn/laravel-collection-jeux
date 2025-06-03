@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<style>
    .hero {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 20px;
        padding: 3rem;
        box-shadow: 0 0 30px rgba(0,0,0,0.05);
        animation: fadeIn 0.8s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .game-preview img {
        object-fit: cover;
        height: 100px;
        width: 100px;
        border-radius: 10px;
    }
</style>

<div class="container py-5">
    <div class="hero text-center mb-5">
        <h1 class="display-5 fw-bold mb-3">🎮 Bienvenue Rayan</h1>
        <p class="lead text-muted mb-4">
            Gère ta collection de jeux avec classe, style, et toute la puissance de Laravel 💪
        </p>
        <a href="{{ route('games.index') }}" class="btn btn-lg btn-primary shadow-sm">
            👉 Voir mes jeux
        </a>
    </div>

    @if(isset($latestGames) && count($latestGames))
    <div class="text-center mb-4">
        <h2 class="h4 mb-3">🎯 Tes 3 derniers jeux ajoutés</h2>
        <div class="d-flex justify-content-center gap-4 flex-wrap">
            @foreach($latestGames as $game)
                <div class="game-preview text-center m-3">
                    @if ($game->cover_path)
                    <img 
                        src="{{ asset('storage/' . $game->cover_path) }}" 
                        alt="Jaquette de {{ $game->title }}" 
                        class="img-fluid"
                        style="max-height: 100px;"
                    >
                    @endif
                    <p class="mt-2 mb-0">{{ $game->title }}</p>
                    <small class="text-muted">{{ $game->platform }}</small>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection


