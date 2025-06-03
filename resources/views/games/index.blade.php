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
        <div class="row mb-4">
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
                <select name="platform" class="form-control">
                    <option value="">Toutes les plateformes</option>
                    @foreach (\App\Enums\Platform::cases() as $platform)
                        <option value="{{ $platform->value }}" 
                            {{ request('platform') === $platform->value ? 'selected' : '' }}>
                            {{ $platform->value }}
                        </option>
                    @endforeach
                </select>
            </div>
    
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Rechercher</button>
            </div>
        </div>
    </form>
    
    @if ($games->total() > 0)
    <p>
        🎮 {{ $games->total() }} jeu{{ $games->total() > 1 ? 'x' : '' }} trouvé{{ $games->total() > 1 ? 's' : '' }}
        @if ($search)
            pour « <strong>{{ $search }}</strong> »
        @endif
        @if ($platform)
            sur la plateforme <strong>{{ $platformEnum?->value }}</strong>

        @endif
    </p>
    @else
    <p>Aucun jeu trouvé avec ces filtres.</p>
    @endif


    @if ($games->isEmpty())
        <div class="alert alert-info">
            Aucun jeu enregistré pour le moment.
        </div>
    @else
        <ul class="list-group">
            @foreach ($games as $game)
    <li class="list-group-item">
        <div class="d-flex align-items-center">
            <div style="width: 150px; min-width: 150px; height: 100px;" class="d-flex align-items-center justify-content-center bg-light rounded">
                @if ($game->cover_path)
                    <img 
                        src="{{ asset('storage/' . $game->cover_path) }}" 
                        alt="Jaquette de {{ $game->title }}" 
                        class="img-fluid"
                        style="max-height: 100px;"
                    >
                @endif
            </div>

            <div class="ms-3 flex-grow-1">
                <strong>{{ $game->title }}</strong>
                ({{ $game->release_year ?? 'Année inconnue' }}) – 
                {{ $game->platform ?? 'Plateforme inconnue' }}
            </div>

            <div class="ms-auto d-flex gap-2">
                <a href="{{ route('games.show', $game) }}" class="btn btn-sm btn-outline-dark">
                    <strong>Voir le détail</strong>
                </a>
                <a href="{{ route('games.edit', ['game' => $game->id, 'page' => request('page')]) }}" class="btn btn-sm btn-outline-primary">
                    ✏️ Modifier
                </a>
                <form action="{{ route('games.destroy', $game) }}" method="POST" onsubmit="return confirm('Tu veux vraiment supprimer ce jeu ? 😥')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">🗑️ Supprimer</button>
                </form>
            </div>
        </div>
    </li>
@endforeach

        </ul>
    @endif
    <div class="mt-4">
        {{ $games->withQueryString()->links() }}
    </div>    
@endsection
