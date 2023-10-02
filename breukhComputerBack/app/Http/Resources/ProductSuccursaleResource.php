<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductSuccursaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "succursale_id" => $this->succursale->id,
            "nom"=>$this->succursale->libelle,
            "addresse"=>$this->succursale->addresse,
            "telephone"=>$this->succursale->telephone,
            'quantite' => $this->quantite,
            "prixDetail" => $this->prixDetail,
            "prixEnGros" => $this->prixEnGros
           
        ];
    }
}
