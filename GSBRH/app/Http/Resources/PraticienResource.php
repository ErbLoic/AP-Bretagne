<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Praticien;

class PraticienResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
{
    return [
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'adresse' => $this->adresse,
            'ville' => json_decode($this->ville),
            'anciennete' => $this->anciennete . ' ans',
            'salaire' => $this->Echelon->salaire_brut . ' €',
            'echelon' => $this->Echelon->id_echelon,
        ];
}

}
