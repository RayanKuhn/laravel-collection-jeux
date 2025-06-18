<?php

namespace App\Http\Controllers;

use Intervention\Image\ImageManager;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use App\Enums\Platform;


class GameController extends Controller
{
    /**
     * Display a listing of the resource.Azy
     */
    public function index()
    {
        $search = request('search');
        $platform = request('platform');
        
        $platformEnum = null;

        if ($platform && in_array($platform, array_column(\App\Enums\Platform::cases(), 'value'))) {
            $platformEnum = \App\Enums\Platform::from($platform);
        }

        $query = Game::query();
        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }
        
        if ($platform) {
            $query->where('platform', $platform);
        }
        $games = $query->orderBy('created_at', 'desc')->paginate(5);
        return view('games.index', compact('games', 'search', 'platformEnum', 'platform'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('games.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validation des données
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'release_year' => 'nullable|integer|min:1950|max:' . date('Y'),
            'platform' => ['nullable', new Enum(Platform::class)],
            'description' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            $image = $request->file('cover');
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();

            $imageManager = new \Intervention\Image\ImageManager(
                new \Intervention\Image\Drivers\Gd\Driver()
            );

            $image = $imageManager->read($image->getPathname());

            $image->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $image->save(storage_path('app/public/covers/' . $filename));

            $validated['cover_path'] = 'covers/' . $filename;
        }
        

        // 2. Insertion en base
        Game::create($validated);

        // 3. Redirection avec message flash
        return redirect()->route('games.index')->with('success', 'Jeu ajouté avec succès 🎉');
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        return view('games.show', compact('game'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        return view('games.edit', compact('game'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        // 1. Valider les données
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'release_year' => 'nullable|integer|min:1950|max:' . date('Y'),
            'platform' => ['nullable', new Enum(Platform::class)],
            'description' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            $image = $request->file('cover');
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
    
            $imageManager = new \Intervention\Image\ImageManager(
                new \Intervention\Image\Drivers\Gd\Driver()
            );
    
            $resized = $imageManager->read($image->getPathname())
                ->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
    
            $resized->save(public_path('storage/covers/' . $filename));
    
            // Supprimer l'ancienne image si elle existe
            if ($game->cover_path) {
                Storage::disk('public')->delete($game->cover_path);
            }
    
            $validated['cover_path'] = 'covers/' . $filename;
        }

        // 2. Mettre à jour le modèle
        $game->update($validated);

        // 3. Rediriger avec message
        return redirect()->route('games.index', ['page' => $request->input('page')])->with('success', 'Jeu modifié avec succès ✏️');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        $game->delete();

        return redirect()->route('games.index')->with('success', 'Jeu supprimé avec succès 🗑️');
    }
}
