<?php

namespace App\Http\Controllers;

use App\Models\Praticien;
use Illuminate\Http\Request;
use App\Http\Resources\PraticienResource;
use App\Models\Connexion;
use App\Models\Note;
use App\Models\Expert;
use OpenApi\Attributes as OA;

#[OA\Info(
    title: "API Praticiens",
    version: "1.0.0",
    description: "API pour gérer les praticiens"
)]
#[OA\Server(
    url: "/api",
    description: "API Server"
)]
#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    scheme: "bearer",
    bearerFormat: "JWT",
    description: "Entrez le token JWT"
)]
class PostController extends Controller
{
    #[OA\Get(
        path: "/praticiens",
        summary: "Liste des praticiens",
        tags: ["Praticiens"],
        responses: [
            new OA\Response(response: 200, description: "Succès")
        ]
    )]
    public function index()
    {
        $praticiens = Praticien::with('Echelon')
        ->get();
        return PraticienResource::collection($praticiens);
    }

    #[OA\Get(
        path: "/praticiens/{id}",
        summary: "Affiche un praticien spécifique",
        tags: ["Praticiens"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Succès")
        ]
    )]
    public function show($id)
    {
        $praticien = Praticien::with('Echelon')->findOrFail($id);
        return new PraticienResource($praticien);
    }

    #[OA\Get(
        path: "/praticiens/nom/{nom}",
        summary: "Affiche un praticien par nom",
        tags: ["Praticiens"],
        parameters: [
            new OA\Parameter(name: "nom", in: "path", required: true, schema: new OA\Schema(type: "string"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Succès")
        ]
    )]
    public function show_by_name($nom)
    {
        $praticien = Praticien::with('Echelon')->where('nom', $nom)->firstOrFail();
        return new PraticienResource($praticien);
    }

    #[OA\Post(
        path: "/praticiens",
        summary: "Crée un nouveau praticien",
        tags: ["Praticiens"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["nom", "prenom", "adresse", "id_ville", "anciennete", "id_echelon"],
                properties: [
                    new OA\Property(property: "nom", type: "string"),
                    new OA\Property(property: "prenom", type: "string"),
                    new OA\Property(property: "adresse", type: "string"),
                    new OA\Property(property: "id_ville", type: "integer"),
                    new OA\Property(property: "anciennete", type: "integer"),
                    new OA\Property(property: "id_echelon", type: "integer")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Praticien créé")
        ]
    )]
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

    #[OA\Put(
        path: "/praticiens/{id}",
        summary: "Met à jour un praticien existant",
        tags: ["Praticiens"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "nom", type: "string"),
                    new OA\Property(property: "prenom", type: "string"),
                    new OA\Property(property: "adresse", type: "string"),
                    new OA\Property(property: "id_ville", type: "integer"),
                    new OA\Property(property: "anciennete", type: "integer"),
                    new OA\Property(property: "id_echelon", type: "integer")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Praticien mis à jour")
        ]
    )]
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

    #[OA\Get(
        path: "/praticiens/search",
        summary: "Recherche des praticiens par nom ou prénom",
        tags: ["Praticiens"],
        parameters: [
            new OA\Parameter(name: "search", in: "query", required: false, schema: new OA\Schema(type: "string"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Succès")
        ]
    )]
    public function search(Request $request)
    {        $search = $request->query('search');    
        $praticiens = Praticien::where('nom', 'like', "%$search%")
            ->orWhere('prenom', 'like', "%$search%")
            ->get();

        if($praticiens->isEmpty()) {
            return response()->json([
                'message' => 'Aucun praticien trouvé pour la recherche : ' . $search
            ], 404);
        }
        return PraticienResource::collection($praticiens);
    }


    #[OA\Delete(
        path: "/praticiens/{id}",
        summary: "Supprime un praticien",
        tags: ["Praticiens"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Praticien supprimé")
        ]
    )]
    public function destroy(string $id)
    {
        $praticien = Praticien::findOrFail($id);
        $praticien->delete();

        return response()->json([
            'message' => 'Praticien supprimé avec succès.'
        ]);
    }


    #[OA\Get(
        path: "/notes",
        summary: "Liste toutes les notes",
        tags: ["Notes"],
        responses: [
            new OA\Response(response: 200, description: "Succès")
        ]
    )]
    public function show_notes(){
        $note = Note::get();
        return $note ?? [
            'message' =>'Aucune note existante'
        ];
    }

    #[OA\Get(
        path: "/notes/{id}",
        summary: "Liste les notes d'un praticien",
        tags: ["Notes"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Succès")
        ]
    )]
    public function show_notes_prat($id){
        $note = Note::where('concerne', $id)->get();
        return $note ?? [
            'message' =>'Aucune note existante'
        ];
    }



    #[OA\Post(
        path: "/note/create",
        summary: "Créer une note pour un praticien",
        tags: ["Notes"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["commentaire", "note"],
                properties: [
                    new OA\Property(property: "commentaire", type: "string"),
                    new OA\Property(property: "note", type: "integer"),
                    new OA\Property(property: "id_praticien", type: "integer")
                ]
            )
        ),
        security: [["bearerAuth" => []]],
        responses: [
            new OA\Response(response: 201, description: "Note créée"),
            new OA\Response(response: 400, description: "Erreur de validation"),
            new OA\Response(response: 401, description: "Non authentifié")
        ]
    )]
    public function add_note(Request $request)
    {
        try {
            $request->validate([
                'commentaire' => 'required|string',
                'note' => 'required|integer|min:0|max:20',
                'id_praticien' => 'required|exists:praticien,id'
            ]);

            $note = Note::create([
                'commentaires' => $request->commentaire,
                'note' => $request->note,
                'concerne' => $request->id_praticien,
                'id_praticiens' => auth('api')->user()->id_praticiens
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Note créée avec succès',
                'data' => $note
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }



}
