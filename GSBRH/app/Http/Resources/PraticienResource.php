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
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'adresse' => $this->adresse,
            'ville' => json_decode($this->ville),
            'note_client' => $this->note_client,
            'note_expert' => $this->note_expert,
            'note_global' => $this->note_global,
        ];
}

}
