<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tauxcalculnet
 * 
 * @property string $code
 * @property int $pourcent
 *
 * @package App\Models
 */
class Tauxcalculnet extends Model
{
	protected $table = 'tauxcalculnet';
	protected $primaryKey = 'code';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'pourcent' => 'int'
	];

	protected $fillable = [
		'pourcent'
	];
}
