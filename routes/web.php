<?php

use App\Http\Controllers\ProfileController;
use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Foundation\Application;
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
    
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';