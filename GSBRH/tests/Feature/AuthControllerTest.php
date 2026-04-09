<?php

namespace Tests\Feature;

use App\Models\Connexion;
use App\Models\Praticien;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
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
    }

    protected function tearDown(): void
    {
        DB::statement('DROP TABLE IF EXISTS connexion');
        DB::statement('DROP TABLE IF EXISTS praticien');
        parent::tearDown();
    }

    private function creerPraticien(): Praticien
    {
        return Praticien::create(['nom' => 'Dupont', 'prenom' => 'Jean', 'adresse' => '12 rue de la Paix', 'anciennete' => 0]);
    }

    private function creerConnexion(int $idPraticien, string $identifiant = 'user_test', string $mdp = 'password123'): Connexion
    {
        return Connexion::create([
            'identifiant'   => $identifiant,
            'mdp'           => Hash::make($mdp),
            'id_praticiens' => $idPraticien,
            'privilèges'    => 0,
        ]);
    }

    // ─── POST /api/auth/login ─────────────────────────────────────────────────

    public function test_login_champs_manquants_retourne_422(): void
    {
        $this->postJson('/api/auth/login', ['mdp' => 'password123'])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['identifiant']);
    }

    public function test_login_mauvais_identifiants_retourne_401(): void
    {
        $this->postJson('/api/auth/login', ['identifiant' => 'inconnu', 'mdp' => 'faux'])
            ->assertStatus(401)
            ->assertJsonPath('status', 'error');
    }

    public function test_login_valide_retourne_token(): void
    {
        $praticien = $this->creerPraticien();
        $this->creerConnexion($praticien->id, 'user_test', 'password123');

        $this->postJson('/api/auth/login', ['identifiant' => 'user_test', 'mdp' => 'password123'])
            ->assertStatus(200)
            ->assertJsonPath('status', 'success')
            ->assertJsonStructure(['authorization' => ['token', 'type', 'expires_in']]);
    }

    // ─── POST /api/auth/register ──────────────────────────────────────────────

    public function test_register_mdp_trop_court_retourne_422(): void
    {
        $praticien = $this->creerPraticien();

        $this->postJson('/api/auth/register', [
            'identifiant'   => 'nouveau_user',
            'mdp'           => '123',
            'id_praticiens' => $praticien->id,
        ])->assertStatus(422)->assertJsonValidationErrors(['mdp']);
    }

    public function test_register_valide_cree_compte_et_retourne_201(): void
    {
        $praticien = $this->creerPraticien();

        $this->postJson('/api/auth/register', [
            'identifiant'   => 'nouveau_user',
            'mdp'           => 'password123',
            'id_praticiens' => $praticien->id,
        ])->assertStatus(201)->assertJsonPath('status', 'success');
    }

    // ─── Routes protégées ─────────────────────────────────────────────────────

    public function test_me_sans_token_retourne_401(): void
    {
        $this->getJson('/api/auth/me')->assertStatus(401);
    }

    public function test_me_avec_token_retourne_utilisateur(): void
    {
        $praticien = $this->creerPraticien();
        $connexion = $this->creerConnexion($praticien->id, 'mon_user');

        $this->actingAs($connexion, 'api')
            ->getJson('/api/auth/me')
            ->assertStatus(200)
            ->assertJsonPath('user.identifiant', 'mon_user');
    }
}
