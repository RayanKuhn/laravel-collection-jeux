@extends('layouts.app')

@section('title', 'Ma collection de jeux')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0">🎮 Ma collection de jeux</h1>
    <a href="{{ route('games.create') }}" class="btn btn-success">
        ➕ Ajouter un jeu
    </a>
</div>

<form method="GET" action="{{ route('games.index') }}">
    <div class="row mb-4 g-2">
        <div class="col-md-4">
            <input 
                type="text" 
                name="search" 
                class="form-control" 
                placeholder="Rechercher un jeu..." 
                value="{{ request('search') }}"
            >
        </div>

        <div class="col-md-4">
            <select name="platform" class="form-select">
                <option value="">Toutes les plateformes</option>
                @foreach (\App\Enums\Platform::cases() as $platform)
                    <option value="{{ $platform->value }}" 
                        {{ request('platform') === $platform->value ? 'selected' : '' }}>
                        {{ $platform->value }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 d-grid">
            <button type="submit" class="btn btn-primary">Rechercher</button>
        </div>
    </div>
</form>

@if ($games->total() > 0)
    <p>
        🎯 {{ $games->total() }} jeu{{ $games->total() > 1 ? 'x' : '' }} trouvé{{ $games->total() > 1 ? 's' : '' }}
        @if ($search)
            pour « <strong>{{ $search }}</strong> »
        @endif
        @if ($platform)
            sur la plateforme <strong>{{ $platformEnum?->value }}</strong>
        @endif
    </p>
@else
    <div class="alert alert-info">
        Aucun jeu trouvé avec ces filtres.
    </div>
@endif

<div class="d-flex flex-column gap-3">
    @foreach ($games as $game)
        <div class="card shadow-sm">
            <div class="row g-0">
                <div class="col-auto d-flex align-items-center justify-content-center bg-light" style="width: 150px;">
                    @if ($game->cover_path)
                        <img 
                            src="{{ asset('storage/' . $game->cover_path) }}" 
                            alt="Jaquette de {{ $game->title }}" 
                            class="img-fluid rounded-start"
                            style="object-fit: cover; height: 150px; width: 150px;"
                        >
                    @else
                        <span class="text-muted small p-3">Aucune image</span>
                    @endif
                </div>
                <div class="col">
                    <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        <div>
                            <h5 class="card-title mb-1">{{ $game->title }}</h5>
                            <p class="card-text small mb-2">
                                {{ $game->release_year ?? 'Année inconnue' }} – 
                                {{ $game->platform ?? 'Plateforme inconnue' }}
                            </p>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('games.show', $game) }}" class="btn btn-sm btn-outline-dark">
                                Voir détail
                            </a>
                            <a href="{{ route('games.edit', ['game' => $game->id, 'page' => request('page')]) }}" class="btn btn-sm btn-outline-primary">
                                ✏️ Modifier
                            </a>
                            <form action="{{ route('games.destroy', $game) }}" method="POST" onsubmit="return confirm('Tu veux vraiment supprimer ce jeu ? 😥')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">🗑️</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="mt-4">
    {{ $games->withQueryString()->links() }}
</div>
@endsection
