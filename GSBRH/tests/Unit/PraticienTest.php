<?php

namespace Tests\Unit;

use App\Models\Praticien;
use PHPUnit\Framework\TestCase;

class PraticienTest extends TestCase
{
    public function test_table_name_est_praticien(): void
    {
        $this->assertEquals('praticien', (new Praticien())->getTable());
    }

    public function test_timestamps_sont_desactives(): void
    {
        $this->assertFalse((new Praticien())->usesTimestamps());
    }

    public function test_fillable_contient_les_champs_principaux(): void
    {
        $fillable = (new Praticien())->getFillable();

        $this->assertContains('nom', $fillable);
        $this->assertContains('prenom', $fillable);
        $this->assertContains('adresse', $fillable);
        $this->assertContains('anciennete', $fillable);
    }

    public function test_anciennete_est_caste_en_int(): void
    {
        $casts = (new Praticien())->getCasts();

        $this->assertArrayHasKey('anciennete', $casts);
        $this->assertEquals('int', $casts['anciennete']);
    }

    public function test_notes_sont_castees_en_float(): void
    {
        $casts = (new Praticien())->getCasts();

        $this->assertEquals('float', $casts['note_client']);
        $this->assertEquals('float', $casts['note_expert']);
        $this->assertEquals('float', $casts['note_global']);
    }

    public function test_relations_existent(): void
    {
        $this->assertTrue(method_exists(Praticien::class, 'ville'));
        $this->assertTrue(method_exists(Praticien::class, 'echelon'));
        $this->assertTrue(method_exists(Praticien::class, 'congés'));
        $this->assertTrue(method_exists(Praticien::class, 'notes'));
    }
}
