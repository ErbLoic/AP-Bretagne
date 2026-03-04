<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Connexion;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    #[OA\Post(
        path: "/auth/login",
        summary: "Connexion utilisateur",
        tags: ["Authentification"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["identifiant", "mdp"],
                properties: [
                    new OA\Property(property: "identifiant", type: "string", example: "user123"),
                    new OA\Property(property: "mdp", type: "string", example: "password")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Connexion réussie"),
            new OA\Response(response: 401, description: "Identifiants incorrects"),
            new OA\Response(response: 500, description: "Erreur serveur")
        ]
    )]
    public function login(Request $request)
    {
        try {
            $request->validate([
                'identifiant' => 'required|string',
                'mdp' => 'required|string',
            ]);

            $user = Connexion::where('identifiant', $request->identifiant)->first();

            if (!$user || !Hash::check($request->mdp, $user->mdp)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Identifiants incorrects',
                ], 401);
            }

            $token = Auth::guard('api')->login($user);

            return $this->respondWithToken($token, $user);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    #[OA\Post(
        path: "/auth/register",
        summary: "Inscription utilisateur",
        tags: ["Authentification"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["identifiant", "mdp", "id_praticiens"],
                properties: [
                    new OA\Property(property: "identifiant", type: "string", example: "newuser"),
                    new OA\Property(property: "mdp", type: "string", example: "password123"),
                    new OA\Property(property: "id_praticiens", type: "integer", example: 1),
                    new OA\Property(property: "privilèges", type: "integer", example: 0)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Utilisateur créé"),
            new OA\Response(response: 422, description: "Erreur de validation")
        ]
    )]
    public function register(Request $request)
    {
        $request->validate([
            'identifiant' => 'required|string|unique:connexion,identifiant',
            'mdp' => 'required|string|min:6',
            'id_praticiens' => 'required|exists:praticien,id',
            'privilèges' => 'integer'
        ]);

        $user = Connexion::create([
            'identifiant' => $request->identifiant,
            'mdp' => Hash::make($request->mdp),
            'id_praticiens' => $request->id_praticiens,
            'privilèges' => $request->privilèges ?? 0,
        ]);

        $token = Auth::guard('api')->login($user);

        return $this->respondWithToken($token, $user, 201);
    }

    #[OA\Post(
        path: "/auth/logout",
        summary: "Déconnexion utilisateur",
        tags: ["Authentification"],
        security: [["bearerAuth" => []]],
        responses: [
            new OA\Response(response: 200, description: "Déconnexion réussie")
        ]
    )]
    public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'Déconnexion réussie',
        ]);
    }

    #[OA\Post(
        path: "/auth/refresh",
        summary: "Rafraîchir le token JWT",
        tags: ["Authentification"],
        security: [["bearerAuth" => []]],
        responses: [
            new OA\Response(response: 200, description: "Token rafraîchi")
        ]
    )]
    public function refresh()
    {
        $token = Auth::guard('api')->refresh();
        $user = Auth::guard('api')->user();

        return $this->respondWithToken($token, $user);
    }

    #[OA\Get(
        path: "/auth/me",
        summary: "Profil utilisateur connecté",
        tags: ["Authentification"],
        security: [["bearerAuth" => []]],
        responses: [
            new OA\Response(response: 200, description: "Profil utilisateur")
        ]
    )]
    public function me()
    {
        $user = Auth::guard('api')->user();
        $user->load('praticien');

        return response()->json([
            'status' => 'success',
            'user' => $user,
        ]);
    }

    /**
     * Helper pour retourner le token avec les infos.
     */
    protected function respondWithToken($token, $user, $statusCode = 200)
    {
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
                'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
            ]
        ], $statusCode);
    }
}
