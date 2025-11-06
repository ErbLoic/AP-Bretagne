<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Echellesalaire
 * 
 * @property string $id
 * @property float $min
 * @property float $max
 * 
 * @property TypePraticien $type_praticien
 *
 * @package App\Models
 */
class Echellesalaire extends Model
{
	protected $table = 'echellesalaires';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'min' => 'float',
		'max' => 'float'
	];

	protected $fillable = [
		'min',
		'max'
	];

	public function type_praticien()
	{
		return $this->belongsTo(TypePraticien::class, 'id');
	}
}
