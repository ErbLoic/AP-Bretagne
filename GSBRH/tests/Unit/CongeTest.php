<?php

namespace Tests\Unit;

use App\Models\Congé;
use PHPUnit\Framework\TestCase;

class CongeTest extends TestCase
{
    public function test_table_name_et_primary_key(): void
    {
        $model = new Congé();

        $this->assertEquals('congé', $model->getTable());
        $this->assertEquals('ID', $model->getKeyName());
    }

    public function test_timestamps_sont_desactives(): void
    {
        $this->assertFalse((new Congé())->usesTimestamps());
    }

    public function test_dates_sont_castees_en_datetime(): void
    {
        $casts = (new Congé())->getCasts();

        $this->assertEquals('datetime', $casts['date_debut']);
        $this->assertEquals('datetime', $casts['date_fin']);
    }

    public function test_fillable_contient_les_champs_requis(): void
    {
        $fillable = (new Congé())->getFillable();

        $this->assertContains('Id_praticien', $fillable);
        $this->assertContains('date_debut', $fillable);
        $this->assertContains('date_fin', $fillable);
        $this->assertContains('état', $fillable);
    }

    public function test_relations_existent(): void
    {
        $this->assertTrue(method_exists(Congé::class, 'praticien'));
        $this->assertTrue(method_exists(Congé::class, 'etat'));
    }
}
