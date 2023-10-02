<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'reduction' => $this->reduction,
            "quantite" => $this->details->quantite,
            "categorie" => $this->categorie->libelle,
            "marque" => $this->marque->libelle,
            "categorie_id" => $this->categorie_id,
            "marque_id" => $this->marque_id,
            "prixDetail" => $this->details->prixDetail,
            "prixEnGros" => $this->details->prixEnGros,
             "succursale_id" => $this->details->succursale_id,
             'image' => $this->photo,
            'caracteristiques' =>   CaracteristiqueResource::collection($this->caracteristiques)
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
