<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Departement
 * 
 * @property int $id
 * @property string|null $code
 * @property string|null $nom_departement
 * @property string|null $nom_reel
 * @property int $id_region
 * 
 * @property Region $region
 * @property Collection|Ville[] $villes
 *
 * @package App\Models
 */
class Departement extends Model
{
	protected $table = 'departement';
	public $timestamps = false;

	protected $casts = [
		'id_region' => 'int'
	];

	protected $fillable = [
		'code',
		'nom_departement',
		'nom_reel',
		'id_region'
	];

	public function region()
	{
		return $this->belongsTo(Region::class, 'id_region');
	}

	public function villes()
	{
		return $this->hasMany(Ville::class, 'id_departement');
	}
}
