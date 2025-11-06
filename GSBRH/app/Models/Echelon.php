<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Echelon
 * 
 * @property int $id_echelon
 * @property string $duree
 * @property float $salaire_brut
 * 
 * @property Collection|Praticien[] $praticiens
 *
 * @package App\Models
 */
class Echelon extends Model
{
	protected $table = 'Echelon';
	protected $primaryKey = 'id_echelon';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_echelon' => 'int',
		'salaire_brut' => 'float'
	];

	protected $fillable = [
		'duree',
		'salaire_brut'
	];

	public function praticiens()
	{
		return $this->hasMany(Praticien::class, 'id_echelon');
	}
}
