<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class Connexion
 * 
 * @property string $identifiant
 * @property string $mdp
 * @property int $id_praticiens
 * @property int $privilèges
 * 
 * @property Praticien $praticien
 * @property Utilisateur $utilisateur
 *
 * @package App\Models
 */
class Connexion extends Authenticatable implements JWTSubject
{
	protected $table = 'connexion';
	protected $primaryKey = 'identifiant';
	protected $keyType = 'string';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_praticiens' => 'int',
		'privilèges' => 'int'
	];

	protected $hidden = [
		'mdp',
	];

	protected $fillable = [
		'identifiant',
		'mdp',
		'id_praticiens',
		'privilèges'
	];

	/**
	 * Get the identifier that will be stored in the JWT.
	 */
	public function getJWTIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Return a key value array, containing any custom claims.
	 */
	public function getJWTCustomClaims()
	{
		return [
			'id_praticiens' => $this->id_praticiens,
			'privileges' => $this->privilèges
		];
	}

	/**
	 * Get the password for the user.
	 */
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
