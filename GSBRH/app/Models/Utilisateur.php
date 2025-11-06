<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Utilisateur
 * 
 * @property int $id
 * @property string $nom
 * @property string $mdp
 * 
 * @property Collection|Connexion[] $connexions
 *
 * @package App\Models
 */
class Utilisateur extends Model
{
	protected $table = 'utilisateur';
	public $timestamps = false;

	protected $fillable = [
		'nom',
		'mdp'
	];

	public function connexions()
	{
		return $this->hasMany(Connexion::class, 'privilèges');
	}
}
