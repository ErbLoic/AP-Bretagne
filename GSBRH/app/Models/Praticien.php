<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Praticien
 * 
 * @property int $id
 * @property string|null $nom
 * @property string|null $prenom
 * @property string|null $adresse
 * @property float|null $coef_notoriete
 * @property string|null $code_type_praticien
 * @property int $id_ville
 * @property float $Solde_congé
 * @property float $Ancien_Solde_Congé
 * @property int $anciennete
 * @property int $id_echelon
 * @property float $note_client
 * @property float $note_expert
 * @property float $note_global
 * 
 * @property TypePraticien|null $type_praticien
 * @property Ville $ville
 * @property Echelon $echelon
 * @property Collection|Congé[] $congés
 * @property Collection|Connexion[] $connexions
 * @property Collection|Note[] $notes
 * @property Collection|Notification[] $notifications
 *
 * @package App\Models
 */
class Praticien extends Model
{
	protected $table = 'praticien';
	public $timestamps = false;

	protected $casts = [
		'coef_notoriete' => 'float',
		'id_ville' => 'int',
		'Solde_congé' => 'float',
		'Ancien_Solde_Congé' => 'float',
		'anciennete' => 'int',
		'id_echelon' => 'int',
		'note_client' => 'float',
		'note_expert' => 'float',
		'note_global' => 'float'
	];

	protected $fillable = [
		'nom',
		'prenom',
		'adresse',
		'coef_notoriete',
		'code_type_praticien',
		'id_ville',
		'Solde_congé',
		'Ancien_Solde_Congé',
		'anciennete',
		'id_echelon',
		'note_client',
		'note_expert',
		'note_global'
	];

	public function type_praticien()
	{
		return $this->belongsTo(TypePraticien::class, 'code_type_praticien');
	}

	public function ville()
	{
		return $this->belongsTo(Ville::class, 'id_ville');
	}

	public function echelon()
	{
		return $this->belongsTo(Echelon::class, 'id_echelon');
	}

	public function congés()
	{
		return $this->hasMany(Congé::class, 'Id_praticien');
	}

	public function connexions()
	{
		return $this->hasMany(Connexion::class, 'id_praticiens');
	}

	public function notes()
	{
		return $this->hasMany(Note::class, 'concerne');
	}

	public function notifications()
	{
		return $this->hasMany(Notification::class, 'id_receveur');
	}
}
