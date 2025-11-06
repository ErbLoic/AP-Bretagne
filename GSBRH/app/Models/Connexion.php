<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Connexion extends Authenticatable
{
    protected $table = 'connexion';
    protected $primaryKey = 'identifiant';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'id_praticiens' => 'int',
        'privilèges' => 'int'
    ];

    protected $fillable = [
        'identifiant',
        'mdp',
        'id_praticiens',
        'privilèges'
    ];

    protected $hidden = [
        'mdp',
    ];

    public function getAuthIdentifierName()
    {
        return 'identifiant';
    }

    public function getAuthPassword()
    {
        return $this->mdp;
    }

    public function praticien()
    {
        return $this->belongsTo(Praticien::class, 'id_praticiens');
    }

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'privilèges');
    }
}
?>