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

Route::get('/dashboard/{year}/{month}', function ($year, $month) {
    // Votre logique de gestion du dashboard ici

   

    // Requête existante pour les quantités totales par jour
    $utilisateur_has_produits = Utilisateur_has_produit::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(quantite) as total_quantite'))
    ->where('action', 'vente')
    ->whereYear('created_at', $year)
    ->whereMonth('created_at', $month)
    ->groupBy(DB::raw('DATE(created_at)'))
    ->get();

    // Requête pour la somme des ventes par utilisateur
    $total_ventes_par_utilisateur = DB::table('utilisateur_has_produits as uhp')
        ->join('users as u', 'uhp.user_id', '=', 'u.id')
        ->join('produits as p', 'uhp.produit_id', '=', 'p.id')
        ->select(
            'uhp.user_id', 
            'u.name as user_name',
            DB::raw('SUM(p.prixVente * uhp.quantite) as total_vente')
        )
        ->where('uhp.action', 'vente')
        ->when($year, function ($query) use ($year) {
            return $query->whereYear('uhp.created_at', $year);
        })
        ->when($month, function ($query) use ($month) {
            return $query->whereMonth('uhp.created_at', $month);
        })
        ->groupBy('uhp.user_id', 'u.name')
        ->get();

    // Requête pour les ventes totales par jour
    $ventes_totales_par_jour = DB::table('utilisateur_has_produits as uhp')
        ->join('produits as p', 'uhp.produit_id', '=', 'p.id')
        ->select(
            DB::raw('DATE(uhp.created_at) as date'),
            DB::raw('SUM(p.prixVente * uhp.quantite) as total_vente')
        )
        ->where('uhp.action', 'vente')
        ->when($year, function ($query) use ($year) {
            return $query->whereYear('uhp.created_at', $year);
        })
        ->when($month, function ($query) use ($month) {
            return $query->whereMonth('uhp.created_at', $month);
        })
        ->groupBy(DB::raw('DATE(uhp.created_at)'))
        ->orderBy(DB::raw('DATE(uhp.created_at)'), 'asc')
        ->get();

    // Requête pour les résultats
    $results = DB::table('utilisateur_has_produits as uhp')
        ->join('produits as p', 'uhp.produit_id', '=', 'p.id')
        ->select('p.reference as reference_produit', DB::raw('SUM(uhp.quantite) as total_quantite'))
        ->where('uhp.action', 'vente')
        ->when($year, function ($query) use ($year) {
            return $query->whereYear('uhp.created_at', $year);
        })
        ->when($month, function ($query) use ($month) {
            return $query->whereMonth('uhp.created_at', $month);
        })
        ->groupBy('uhp.produit_id', 'p.reference')
        ->orderByDesc('total_quantite')
        ->get();

    // Requête pour les ventes par mois par utilisateur
    $ventes_par_mois_par_utilisateur = DB::table('utilisateur_has_produits as uhp')
        ->join('users as u', 'uhp.user_id', '=', 'u.id')
        ->select(
            'u.id as user_id',
            'u.name as user_name',
            DB::raw('YEAR(uhp.created_at) as year'),
            DB::raw('MONTH(uhp.created_at) as month'),
            DB::raw('SUM(uhp.quantite) as total_quantite')
        )
        ->where('uhp.action', 'vente')
        ->when($year, function ($query) use ($year) {
            return $query->whereYear('uhp.created_at', $year);
        })
        ->when($month, function ($query) use ($month) {
            return $query->whereMonth('uhp.created_at', $month);
        })
        ->groupBy('u.id', 'u.name', DB::raw('YEAR(uhp.created_at)'), DB::raw('MONTH(uhp.created_at)'))
        ->orderBy('u.id')
        ->orderBy(DB::raw('YEAR(uhp.created_at)'))
        ->orderBy(DB::raw('MONTH(uhp.created_at)'))
        ->get();

    return inertia('Dashboard', [
        'utilisateur_has_produits' => $utilisateur_has_produits,
        'total_ventes_par_utilisateur' => $total_ventes_par_utilisateur,
        'ventes_totales_par_jour' => $ventes_totales_par_jour,
        'results' => $results,
        'ventes_par_mois_par_utilisateur' => $ventes_par_mois_par_utilisateur
    ]);

    // return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';