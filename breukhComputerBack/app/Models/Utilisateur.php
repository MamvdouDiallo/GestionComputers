<?php

namespace App\Models;

use App\Models\Succursale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Utilisateur extends User
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'deleted_at', 'updated_at','password'];
    public function  succursale(): BelongsTo
    {
        return $this->belongsTo(Succursale::class);
    }
}
