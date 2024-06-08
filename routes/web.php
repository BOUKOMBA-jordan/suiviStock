<?php

use App\Http\Controllers\ProfileController;
use App\Http\Resources\Utilisateur_has_produitResource;
use App\Models\Categorie;
use App\Models\utilisateur_has_produit;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {

    /*$Categorie = new Categorie();
    $Categorie->type = 'céréale';
    $Categorie->save();
    return \App\Models\Categorie::all();*/

    /*$produits = new Produit();
    $produits->reference =' 12 LAIT INFANTILE 2 EME AGE *400G ';
    $produits->quantite ='50';
    $produits->prixAchat ='3000';
    $produits->prixVente ='40440';
    $produits->categorie_id ='3';
    $produits->save();
    return \App\Models\Produit::all();*/

    /*$utilisateur_has_produit = new utilisateur_has_produit();
    $utilisateur_has_produit->user_id = 4;
    $utilisateur_has_produit->produit_id = 5;
    $utilisateur_has_produit->action = 'livrer';
    $utilisateur_has_produit->quantite = 25;
    $utilisateur_has_produit->save();
    return \App\Models\utilisateur_has_produit::all();*/

    /*Categorie::create([
        'type' => 'Céréale'
    ]);*/

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('produit', \App\Http\Controllers\Admin\ProduitController::class)->except('show');
    Route::resource('categorie', \App\Http\Controllers\Admin\CategorieController::class)->except('show');
    Route::resource('utilisateurHasProduit', \App\Http\Controllers\Admin\Utilisateur_has_produitController::class)->except('show');

});

Route::get('/dashboard', function () {

    $utilisateur_has_produits = Utilisateur_has_produit::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(quantite) as total_quantite'))
        ->where('action', 'vente')
        ->groupBy(DB::raw('DATE(created_at)'))
        ->get();
    

    return inertia('Dashboard', [
        'utilisateur_has_produits' => $utilisateur_has_produits,
    ]);

    // return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';