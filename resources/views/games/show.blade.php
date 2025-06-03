@extends('layouts.app')

@section('title', $game->title)

@section('content')
<div class="mb-4">
    <a href="{{ route('games.index') }}" class="btn btn-outline-primary">
        ⬅️ Retour à la liste
    </a>
</div>

<div class="card shadow-sm p-3 mb-4">
    <div class="row g-4 align-items-center">
        @if ($game->cover_path)
            <div class="col-md-4 text-center">
                <img 
                    src="{{ asset('storage/' . $game->cover_path) }}" 
                    alt="Jaquette de {{ $game->title }}" 
                    class="img-fluid rounded" 
                    style="max-height: 280px; object-fit: contain;"
                >
            </div>
        @endif

        <div class="col-md">
            <h2 class="mb-3">{{ $game->title }}</h2>

            <p class="mb-1">
                <strong>📅 Année :</strong> {{ $game->release_year ?? 'Inconnue' }}
            </p>
            <p class="mb-1">
                <strong>🕹️ Plateforme :</strong> {{ $game->platform ?? 'Inconnue' }}
            </p>

            @if ($game->description)
                <p class="mt-3">
                    <strong>📝 Description :</strong><br>
                    {{ $game->description }}
                </p>
            @endif

            <div class="d-flex gap-2 mt-4 flex-wrap">
                <a href="{{ route('games.edit', $game) }}" class="btn btn-outline-primary">
                    ✏️ Modifier
                </a>

                <form action="{{ route('games.destroy', $game) }}" method="POST"
                      onsubmit="return confirm('Tu veux vraiment supprimer ce jeu ? 😥')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">
                        🗑️ Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
