<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 * 
 * @property int $id_notif
 * @property int $id_ecrivian
 * @property int $id_receveur
 * @property string $message
 * @property int $id_etat
 * 
 * @property Praticien $praticien
 * @property EtatLecture $etat_lecture
 *
 * @package App\Models
 */
class Notification extends Model
{
	protected $table = 'notification';
	protected $primaryKey = 'id_notif';
	public $timestamps = false;

	protected $casts = [
		'id_ecrivian' => 'int',
		'id_receveur' => 'int',
		'id_etat' => 'int'
	];

	protected $fillable = [
		'id_ecrivian',
		'id_receveur',
		'message',
		'id_etat'
	];

	public function praticien()
	{
		return $this->belongsTo(Praticien::class, 'id_receveur');
	}

	public function etat_lecture()
	{
		return $this->belongsTo(EtatLecture::class, 'id_etat');
	}
}
