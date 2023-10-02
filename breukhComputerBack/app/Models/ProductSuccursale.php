<?php

namespace App\Models;

use App\Models\Succursale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductSuccursale extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    
    public function succursale():BelongsTo
    {
        return $this->belongsTo(Succursale::class,'succursale_id','id');
    }

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected $hidden = ['created_at', 'updated_at', 'deleted_at','product_id'];
}
