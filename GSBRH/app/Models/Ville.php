<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ville
 * 
 * @property int $id
 * @property string|null $nom_ville
 * @property string|null $nom_reel
 * @property string|null $code_postal
 * @property string|null $commune
 * @property string $code_commune
 * @property int|null $arrondissement
 * @property int $id_departement
 * 
 * @property Departement $departement
 * @property Collection|Praticien[] $praticiens
 *
 * @package App\Models
 */
class Ville extends Model
{
	protected $table = 'ville';
	public $timestamps = false;

	protected $casts = [
		'arrondissement' => 'int',
		'id_departement' => 'int'
	];

	protected $fillable = [
		'nom_ville',
		'nom_reel',
		'code_postal',
		'commune',
		'code_commune',
		'arrondissement',
		'id_departement'
	];

	public function departement()
	{
		return $this->belongsTo(Departement::class, 'id_departement');
	}

	public function praticiens()
	{
		return $this->hasMany(Praticien::class, 'id_ville');
	}
}
