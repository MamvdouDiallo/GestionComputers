<?php

use App\Models\Commande;
use App\Models\ProductSuccursale;
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
        Schema::create('produit_commandes', function (Blueprint $table) {
            $table->id();
            $table->float('prix_vente');
            $table->float('quantity');
            $table->foreignIdFor(Commande::class);
            $table->foreignIdFor(ProductSuccursale::class);
            $table->float('reduction')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produit_commandes');
    }
};
