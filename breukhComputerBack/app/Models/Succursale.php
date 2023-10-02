<?php

namespace App\Models;

use App\Models\Ami;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Succursale extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function produtcs(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_succursales');
    }

    public function friends(): HasMany
    {
        return $this->hasMany(Ami::class);
    }
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
