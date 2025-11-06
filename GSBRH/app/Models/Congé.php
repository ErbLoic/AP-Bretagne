<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Congé
 * 
 * @property int $ID
 * @property int $Id_praticien
 * @property Carbon $date_debut
 * @property Carbon $date_fin
 * @property int $état
 * 
 * @property Etat $etat
 * @property Praticien $praticien
 *
 * @package App\Models
 */
class Congé extends Model
{
	protected $table = 'congé';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'Id_praticien' => 'int',
		'date_debut' => 'datetime',
		'date_fin' => 'datetime',
		'état' => 'int'
	];

	protected $fillable = [
		'Id_praticien',
		'date_debut',
		'date_fin',
		'état'
	];

	public function etat()
	{
		return $this->belongsTo(Etat::class, 'état');
	}

	public function praticien()
	{
		return $this->belongsTo(Praticien::class, 'Id_praticien');
	}
}
