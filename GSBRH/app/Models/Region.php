<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Region
 * 
 * @property int $id
 * @property string|null $code
 * @property string|null $nom
 * @property string|null $nom_reel
 * @property string|null $commune
 * @property string|null $monnaie
 * @property string|null $fuseau
 * @property string|null $indicatif
 * 
 * @property Collection|Departement[] $departements
 *
 * @package App\Models
 */
class Region extends Model
{
	protected $table = 'region';
	public $timestamps = false;

	protected $fillable = [
		'code',
		'nom',
		'nom_reel',
		'commune',
		'monnaie',
		'fuseau',
		'indicatif'
	];

	public function departements()
	{
		return $this->hasMany(Departement::class, 'id_region');
	}
}
