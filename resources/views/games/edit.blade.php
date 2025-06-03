@extends('layouts.app')

@section('title', 'Modifier un jeu')

@section('content')
    <h1 class="mb-4">📝 Modifier le jeu</h1>

    <form action="{{ route('games.update', $game->id) }}" method="POST" enctype="multipart/form-data" class="border p-4 bg-white shadow-sm rounded">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $game->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="release_year" class="form-label">Année de sortie</label>
            <input type="number" id="release_year" name="release_year" class="form-control" value="{{ old('release_year', $game->release_year) }}">
        </div>

        <div class="mb-3">
            <label for="platform" class="form-label">Plateforme</label>
            <select id="platform" name="platform" class="form-control">
                <option value="">-- Choisir une plateforme --</option>
                @foreach (\App\Enums\Platform::cases() as $platform)
                    <option value="{{ $platform->value }}" {{ old('platform', $game->platform) === $platform->value ? 'selected' : '' }}>
                        {{ $platform->value }}
                    </option>
                @endforeach
            </select>
            
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" rows="4" class="form-control">{{ old('description', $game->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="cover">Modifier ou ajouter une image :</label>
            <input type="file" name="cover" id="cover" class="form-control">
        </div>
    
        @if ($game->cover_path)
            <div class="mb-3">
                <img src="{{ asset('storage/' . $game->cover_path) }}" alt="Image actuelle" style="max-width: 150px;">
            </div>
        @endif
        
        <input type="hidden" name="page" value="{{ request('page') }}">
        <button type="submit" class="btn btn-outline-primary m-3">Enregistrer les modifications</button>
    </form>
@endsection
