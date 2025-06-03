@extends('layouts.app')

@section('title', 'Modifier un jeu')

@section('content')
<h1 class="mb-4">📝 Modifier le jeu</h1>

<form action="{{ route('games.update', $game->id) }}" method="POST" enctype="multipart/form-data" class="border p-4 bg-white shadow-sm rounded">
    @csrf
    @method('PUT')

    <div class="form-floating mb-3">
        <input type="text" id="title" name="title"
            class="form-control @error('title') is-invalid @enderror"
            placeholder="Titre"
            value="{{ old('title', $game->title) }}"
            required>
        <label for="title">Titre du jeu</label>
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-floating mb-3">
        <input type="number" id="release_year" name="release_year"
            class="form-control @error('release_year') is-invalid @enderror"
            placeholder="Année de sortie"
            value="{{ old('release_year', $game->release_year) }}">
        <label for="release_year">Année de sortie</label>
        @error('release_year')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="platform" class="form-label">Plateforme</label>
        <select id="platform" name="platform" class="form-select @error('platform') is-invalid @enderror">
            <option value="">-- Choisir une plateforme --</option>
            @foreach (\App\Enums\Platform::cases() as $platform)
                <option value="{{ $platform->value }}" {{ old('platform', $game->platform) === $platform->value ? 'selected' : '' }}>
                    {{ $platform->value }}
                </option>
            @endforeach
        </select>
        @error('platform')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-floating mb-3">
        <textarea id="description" name="description"
            class="form-control @error('description') is-invalid @enderror"
            style="height: 120px"
            placeholder="Description">{{ old('description', $game->description) }}</textarea>
        <label for="description">Description</label>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="cover" class="form-label">Modifier ou ajouter une image :</label>
        <input type="file" name="cover" id="cover" class="form-control @error('cover') is-invalid @enderror">
        @error('cover')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    @if ($game->cover_path)
        <div class="mb-3">
            <img src="{{ asset('storage/' . $game->cover_path) }}" alt="Image actuelle" class="img-thumbnail" style="max-width: 150px;">
        </div>
    @endif

    <input type="hidden" name="page" value="{{ request('page') }}">

    <button type="submit" class="btn btn-primary">💾 Enregistrer les modifications</button>
</form>
@endsection

