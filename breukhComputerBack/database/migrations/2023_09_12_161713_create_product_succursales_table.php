<?php

use App\Models\Product;
use App\Models\Succursale;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_succursales', function (Blueprint $table) {
            $table->id();
            $table->float('prixDetail');
            $table->float('prixEnGros');
            $table->float('quantite');
            $table->foreignIdFor(Succursale::class);
            $table->foreignIdFor(Product::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_succursales');
    }
};
