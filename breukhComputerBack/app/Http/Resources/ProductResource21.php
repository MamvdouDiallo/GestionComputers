<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource21 extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'libelle' => $this->libelle,
            'code' => $this->code,
           // 'reduction' => $this->reduction,
            "quantite" => $this->succursales[0]->pivot->quantite,
            "categorie_id" => $this->categorie->id,
            "marque_id" => $this->marque->id,
            "prixDetail" => $this->succursales[0]->pivot->prixDetail,
            "prixEnGros" => $this->succursales[0]->pivot->prixEnGros,
            "succursale_id" => $this->succursales[0]->pivot->succursale_id,
            'image' => $this->photo,
            'caracteristiques' =>   CaracteristiqueResource2::collection($this->caracteristiques)
            //  "succursales" =>  ProductSuccursaleResource::collection($this->productSuccursales),

        ];
    }


    private function generateImageUrl()
    {

        if ($this->photo) {
            $path = 'images/' . $this->photo;
            return asset('storage/' . $path);
        }

        return null;
    }
}
