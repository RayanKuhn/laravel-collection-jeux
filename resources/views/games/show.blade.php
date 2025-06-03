@extends('layouts.app')

@section('title', $game->title)

@section('content')
    <div class="mb-4">
        <a href="{{ route('games.index') }}" class="btn btn-outline-primary">
            ⬅️ Retour à la liste
        </a>
    </div>

    <div class="card mb-4">
        <div class="row g-0">
            @if ($game->cover_path)
                <div class="col-md-4 text-center p-3">
                    <img 
                        src="{{ asset('storage/' . $game->cover_path) }}" 
                        alt="Jaquette de {{ $game->title }}" 
                        class="img-fluid rounded" 
                        style="max-height: 300px; object-fit: contain;"
                    >
                </div>
            @endif

            <div class="col-md-8">
                <div class="card-body">
                    <h2 class="card-title">{{ $game->title }}</h2>

                    <p class="card-text">
                        <strong>Plateforme :</strong> {{ $game->platform ?? 'Inconnue' }}<br>
                        <strong>Année de sortie :</strong> {{ $game->release_year ?? 'Inconnue' }}
                    </p>

                    @if ($game->description)
                        <p class="card-text">
                            <strong>Description :</strong><br>
                            {{ $game->description }}
                        </p>
                    @endif

                    <div class="d-flex gap-2">
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
    </div>
@endsection
