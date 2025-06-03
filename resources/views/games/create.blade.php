@extends('layouts.app')

@section('title', 'Ajouter un jeu')

@section('content')
    <h1 class="mb-4">🎮 Ajouter un nouveau jeu</h1>

    <form action="{{ route('games.store') }}" method="POST" enctype="multipart/form-data" class="border p-4 bg-white shadow-sm rounded">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="release_year" class="form-label">Année de sortie</label>
            <input type="number" id="release_year" name="release_year" class="form-control">
        </div>

        <div class="mb-3">
            <label for="platform" class="form-label">Plateforme</label>
            <select id="platform" name="platform" class="form-control">
                <option value="">-- Choisir une plateforme --</option>
                @foreach (\App\Enums\Platform::cases() as $platform)
                    <option value="{{ $platform->value }}">{{ $platform->value }}</option>
                @endforeach
            </select>
            
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" rows="4" class="form-control"></textarea>
        </div>

        <div class="form-group mt-3">
            <label for="cover">Image de jaquette</label>
            <input type="file" name="cover" id="cover" class="form-control">
        </div>        

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
@endsection
