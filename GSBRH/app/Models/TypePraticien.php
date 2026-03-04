<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TypePraticien
 * 
 * @property string $code
 * @property string|null $libelle
 * @property string|null $lieu
 * @property string $type
 * 
 * @property Collection|Praticien[] $praticiens
 *
 * @package App\Models
 */
class TypePraticien extends Model
{
	protected $table = 'type_praticien';
	protected $primaryKey = 'code';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'libelle',
		'lieu',
		'type'
	];

	public function praticiens()
	{
		return $this->hasMany(Praticien::class, 'code_type_praticien');
	}
}
