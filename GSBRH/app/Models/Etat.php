<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Etat
 * 
 * @property int $Id_etat
 * @property string $Nom_etat
 * 
 * @property Collection|Congé[] $congés
 *
 * @package App\Models
 */
class Etat extends Model
{
	protected $table = 'etat';
	protected $primaryKey = 'Id_etat';
	public $timestamps = false;

	protected $fillable = [
		'Nom_etat'
	];

	public function congés()
	{
		return $this->hasMany(Congé::class, 'état');
	}
}
