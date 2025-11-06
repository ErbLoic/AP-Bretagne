<?php

namespace App\Http\Controllers;

use App\Models\Praticien;
use Illuminate\Http\Request;
use App\Http\Resources\PraticienResource;

class PostController extends Controller
{
    /**
     * Affiche la liste de tous les praticiens.
     */
    public function index()
    {
        $praticiens = Praticien::with('Echelon')->get();
        return PraticienResource::collection($praticiens);
    }

    /**
     * Affiche un praticien spécifique.
     */
    public function show($id)
    {
        $praticien = Praticien::with('Echelon')->findOrFail($id);
        return new PraticienResource($praticien);
    }

    /**
     * Crée un nouveau praticien.
     */
    public function store(Request $request)
    {
        // Validation des données reçues
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'id_ville' => 'required|exists:ville,id',
            'anciennete' => 'required|integer|min:0',
            'id_echelon' => 'required|exists:Echelon,id_Echelon',
        ]);

        // Création du praticien
        $praticien = Praticien::create($validatedData);

        return new PraticienResource($praticien);
    }

    /**
     * Met à jour un praticien existant.
     */
    public function update(Request $request, string $id)
    {
        $praticien = Praticien::findOrFail($id);

        // Validation (tous les champs sont optionnels)
        $validatedData = $request->validate([
             'nom' => 'sometimes|string|max:255',
            'prenom' => 'sometimes|string|max:255',
            'adresse' => 'sometimes|string|max:255',
            'id_ville' => 'sometimes|exists:ville,id',
            'anciennete' => 'sometimes|integer|min:0',
            'id_echelon' => 'sometimes|exists:Echelon,id_Echelon',
        ]);

        $praticien->update($validatedData);

        return new PraticienResource($praticien);
    }

    /**
     * Supprime un praticien.
     */
    public function destroy(string $id)
    {
        $praticien = Praticien::findOrFail($id);
        $praticien->delete();

        return response()->json([
            'message' => 'Praticien supprimé avec succès.'
        ]);
    }
}
