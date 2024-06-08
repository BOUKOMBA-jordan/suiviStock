<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Utilisateur_has_produit;
use App\Http\Resources\Utilisateur_has_produitResource;
class Utilisateur_has_produitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Utilisateur_has_produit::query();
        $utilisateur_has_produits = $query->paginate(10)->onEachSide(1);
        return inertia('Admin/UtilisateurHasProduit', [
           "utilisateur_has_produits" => Utilisateur_has_produitResource::collection($utilisateur_has_produits),
        ]);

        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}