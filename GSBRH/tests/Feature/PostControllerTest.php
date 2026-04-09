<?php

namespace Tests\Feature;

use App\Models\Connexion;
use App\Models\Praticien;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Tables requises par les relations chargées dans PraticienResource (ville) et PostController (Echelon)
        DB::statement('CREATE TABLE IF NOT EXISTS ville (id INTEGER PRIMARY KEY)');
        DB::statement('CREATE TABLE IF NOT EXISTS Echelon (
            id_echelon INTEGER PRIMARY KEY,
            duree INTEGER DEFAULT 0,
            salaire_brut REAL DEFAULT 0
        )');
        DB::statement('CREATE TABLE IF NOT EXISTS praticien (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nom TEXT, prenom TEXT, adresse TEXT,
            coef_notoriete REAL, code_type_praticien TEXT,
            id_ville INTEGER DEFAULT 0,
            "Solde_congé" REAL DEFAULT 0, "Ancien_Solde_Congé" REAL DEFAULT 0,
            anciennete INTEGER DEFAULT 0, id_echelon INTEGER DEFAULT 0,
            note_client REAL DEFAULT 0, note_expert REAL DEFAULT 0, note_global REAL DEFAULT 0
        )');
        DB::statement('CREATE TABLE IF NOT EXISTS connexion (
            identifiant TEXT PRIMARY KEY, mdp TEXT,
            id_praticiens INTEGER, "privilèges" INTEGER DEFAULT 0
        )');
        DB::statement('CREATE TABLE IF NOT EXISTS notes (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            commentaires TEXT, note INTEGER, id_praticiens INTEGER,
            id_expert INTEGER, concerne INTEGER
        )');
    }

    protected function tearDown(): void
    {
        DB::statement('DROP TABLE IF EXISTS notes');
        DB::statement('DROP TABLE IF EXISTS connexion');
        DB::statement('DROP TABLE IF EXISTS praticien');
        DB::statement('DROP TABLE IF EXISTS Echelon');
        DB::statement('DROP TABLE IF EXISTS ville');
        parent::tearDown();
    }

    private function creerPraticien(array $data = []): Praticien
    {
        return Praticien::create(array_merge(
            ['nom' => 'Dupont', 'prenom' => 'Jean', 'adresse' => '12 rue de la Paix', 'anciennete' => 0],
            $data
        ));
    }

    private function creerConnexion(int $idPraticien): Connexion
    {
        return Connexion::create([
            'identifiant'   => 'user_test',
            'mdp'           => Hash::make('password123'),
            'id_praticiens' => $idPraticien,
            'privilèges'    => 0,
        ]);
    }

    // ─── GET /api/praticiens ──────────────────────────────────────────────────

    public function test_liste_praticiens_retourne_200(): void
    {
        $this->getJson('/api/praticiens')->assertStatus(200);
    }

    public function test_liste_praticiens_retourne_les_enregistrements(): void
    {
        $this->creerPraticien(['nom' => 'Martin']);
        $this->creerPraticien(['nom' => 'Bernard']);

        $this->getJson('/api/praticiens')->assertJsonCount(2, 'data');
    }

    // ─── GET /api/praticiens/{id} ─────────────────────────────────────────────

    public function test_afficher_praticien_retourne_les_bonnes_donnees(): void
    {
        $praticien = $this->creerPraticien(['nom' => 'Leclerc', 'prenom' => 'Sophie']);

        $this->getJson("/api/praticiens/{$praticien->id}")
            ->assertStatus(200)
            ->assertJsonPath('data.nom', 'Leclerc')
            ->assertJsonPath('data.prenom', 'Sophie');
    }

    public function test_afficher_praticien_inexistant_retourne_404(): void
    {
        $this->getJson('/api/praticiens/9999')->assertStatus(404);
    }

    // ─── GET /api/praticiens/search ───────────────────────────────────────────

    public function test_recherche_retourne_resultats(): void
    {
        $this->creerPraticien(['nom' => 'Dupont']);

        $this->getJson('/api/praticiens/search?search=Dup')->assertStatus(200);
    }

    public function test_recherche_sans_resultat_retourne_404(): void
    {
        $this->getJson('/api/praticiens/search?search=ZZZZINCONNU')->assertStatus(404);
    }

    // ─── Endpoints protégés ───────────────────────────────────────────────────

    public function test_creer_modifier_supprimer_sans_token_retourne_401(): void
    {
        $praticien = $this->creerPraticien();

        $this->postJson('/api/praticiens', [])->assertStatus(401);
        $this->putJson("/api/praticiens/{$praticien->id}", [])->assertStatus(401);
        $this->deleteJson("/api/praticiens/{$praticien->id}")->assertStatus(401);
    }

    public function test_supprimer_praticien_avec_token(): void
    {
        $praticien  = $this->creerPraticien();
        $connexion  = $this->creerConnexion($praticien->id);

        $this->actingAs($connexion, 'api')
            ->deleteJson("/api/praticiens/{$praticien->id}")
            ->assertStatus(200)
            ->assertJsonPath('message', 'Praticien supprimé avec succès.');
    }
}
