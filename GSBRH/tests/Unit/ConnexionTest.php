<?php

namespace Tests\Unit;

use App\Models\Connexion;
use PHPUnit\Framework\TestCase;

class ConnexionTest extends TestCase
{
    public function test_primary_key_et_configuration(): void
    {
        $model = new Connexion();

        $this->assertEquals('identifiant', $model->getKeyName());
        $this->assertFalse($model->getIncrementing());
        $this->assertFalse($model->usesTimestamps());
    }

    public function test_mdp_est_cache(): void
    {
        $this->assertContains('mdp', (new Connexion())->getHidden());
    }

    public function test_get_auth_password_retourne_mdp(): void
    {
        $model = new Connexion();
        $model->mdp = 'hash_bcrypt';

        $this->assertEquals('hash_bcrypt', $model->getAuthPassword());
    }

    public function test_jwt_identifier_retourne_identifiant(): void
    {
        $model = new Connexion();
        $model->identifiant = 'user_test';

        $this->assertEquals('user_test', $model->getJWTIdentifier());
    }

    public function test_jwt_custom_claims_contient_id_praticiens_et_privileges(): void
    {
        $model = new Connexion();
        $model->id_praticiens = 5;
        $model->{'privilèges'} = 1;

        $claims = $model->getJWTCustomClaims();

        $this->assertEquals(5, $claims['id_praticiens']);
        $this->assertEquals(1, $claims['privileges']);
    }
}
