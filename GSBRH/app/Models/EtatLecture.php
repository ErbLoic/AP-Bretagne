<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EtatLecture
 * 
 * @property int $id
 * @property string $libelle
 * 
 * @property Collection|Notification[] $notifications
 *
 * @package App\Models
 */
class EtatLecture extends Model
{
	protected $table = 'etat_lecture';
	public $timestamps = false;

	protected $fillable = [
		'libelle'
	];

	public function notifications()
	{
		return $this->hasMany(Notification::class, 'id_etat');
	}
}
