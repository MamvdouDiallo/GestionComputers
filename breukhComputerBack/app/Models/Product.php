<?php

namespace App\Models;

use App\Models\Succursale;
use App\Models\Caracteristique;
use App\Models\ProductSuccursale;
use App\Models\CaracteristiqueProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function caracteristiques(): BelongsToMany
    {
        return $this->belongsToMany(Caracteristique::class, 'caracteristique_products')
            ->withPivot("description", "valeur");
    }
    public function marque(): BelongsTo
    {
        return $this->belongsTo(Marque::class);
    }
    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }
    public function succursales(): BelongsToMany
    {
        return $this->belongsToMany(Succursale::class, 'product_succursales')
            ->withPivot("quantite", "prixDetail", "prixEnGros");
    }

    public function productSuccursales(): HasMany
    {
        return $this->hasMany(ProductSuccursale::class);
    }
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
