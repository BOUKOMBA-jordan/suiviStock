<?php

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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->integer('quantite')->nullable();
            $table->integer('prixAchat')->nullable();;
            $table->integer('prixVente');
            $table->timestamps();
        });

        Schema::create('utilisateur_has_produit', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Produit::class)->constrained()->cascadeOnDelete();
            $table->string('action')->unique();
            $table->integer('quantite')->nullable();
            $table->timestamps();
            $table->primary(['user_id', 'produit_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateur_has_produit');
        Schema::dropIfExists('produits');
    }
};