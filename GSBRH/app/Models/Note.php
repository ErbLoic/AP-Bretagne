<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

/**
 * Class Note
 * 
 * @property int $id
 * @property string $commentaires
 * @property int $note
 * @property int|null $id_praticiens
 * @property int|null $id_expert
 * @property int $concerne
 * 
 * @property Praticien $praticien
 * @property Expert|null $expert
 *
 * @package App\Models
 */
class Note extends Model
{
	protected $table = 'notes';
	public $timestamps = false;

	protected $casts = [
		'note' => 'int',
		'id_praticiens' => 'int',
		'id_expert' => 'int',
		'concerne' => 'int'
	];

	protected $fillable = [
		'commentaires',
		'note',
		'id_praticiens',
		'id_expert',
		'concerne'
	];

	public function praticien()
	{
		return $this->belongsTo(Praticien::class, 'concerne');
	}

	public function expert()
	{
		return $this->belongsTo(Expert::class, 'id_expert');
	}
}
