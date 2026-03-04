<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Expert
 * 
 * @property int $id
 * @property string $adresse_mail
 * @property int $mdp
 * 
 * @property Collection|Note[] $notes
 *
 * @package App\Models
 */
class Expert extends Model
{
	protected $table = 'expert';
	public $timestamps = false;

	protected $casts = [
		'mdp' => 'int'
	];

	protected $fillable = [
		'adresse_mail',
		'mdp'
	];

	public function notes()
	{
		return $this->hasMany(Note::class, 'id_expert');
	}
}
