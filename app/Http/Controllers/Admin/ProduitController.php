<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    // 1. LISTE DES PRODUITS
    public function index()
    {
        $produits = Produit::orderBy('nom', 'asc')->get();
        return view('admin.produits.index', compact('produits'));
    }

    // 2. FORMULAIRE D'AJOUT
    public function create()
    {
        return view('admin.produits.create');
    }

    // 3. ENREGISTRER LE PRODUIT
    public function store(Request $request)
{
    $request->validate([
        'nom' => 'required',
        'categorie' => 'required',
        'prix' => 'required|numeric',
        'stock' => 'required|integer',
        'date_peremption' => 'required|date',
    ]);

    // On prépare les données
    $data = $request->all();
    // Astuce : On force la valeur à TRUE si coché, FALSE sinon
    $data['sur_ordonnance'] = $request->has('sur_ordonnance');

    Produit::create($data);

    return redirect()->route('admin.produits.index')->with('success', 'Produit ajouté avec succès !');
}

    //  AFFICHER LE FORMULAIRE DE MODIFICATION
    public function edit($id)
    {
        $produit = Produit::findOrFail($id);
        return view('admin.produits.edit', compact('produit'));
    }

    //  METTRE À JOUR LE PRODUIT
    public function update(Request $request, $id)
{
    $request->validate([
        'nom' => 'required',
        'categorie' => 'required',
        'prix' => 'required|numeric',
        'stock' => 'required|integer',
        'date_peremption' => 'required|date',
    ]);

    $produit = Produit::findOrFail($id);

    $data = $request->all();
    // Même astuce pour la mise à jour
    $data['sur_ordonnance'] = $request->has('sur_ordonnance');

    $produit->update($data);

    return redirect()->route('admin.produits.index')->with('success', 'Produit modifié avec succès !');
}

    //  SUPPRIMER
    public function destroy($id)
    {
        Produit::findOrFail($id)->delete();
        return back()->with('success', 'Produit supprimé.');
    }
}