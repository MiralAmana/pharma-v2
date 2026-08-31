<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProduitRequest;
use App\Http\Requests\UpdateProduitRequest;
use App\Models\Lot;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller
{
    // 1. LISTE DES PRODUITS
    public function index()
    {
        $produits = Produit::orderBy('nom', 'asc')->paginate(15);

        return view('admin.produits.index', compact('produits'));
    }

    // 2. FORMULAIRE D'AJOUT
    public function create()
    {
        return view('admin.produits.create');
    }

    // 3. ENREGISTRER LE PRODUIT
    public function store(StoreProduitRequest $request)
    {
        $data = $request->safe()->except(['stock_initial', 'date_peremption_initiale']);

        // Astuce : On force la valeur à TRUE si coché, FALSE sinon
        $data['sur_ordonnance'] = $request->has('sur_ordonnance');
        $data['stock'] = 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('produits', 'public');
        }

        $produit = Produit::create($data);

        if ($request->integer('stock_initial') > 0) {
            $produit->lots()->create([
                'quantite' => $request->integer('stock_initial'),
                'date_peremption' => $request->input('date_peremption_initiale'),
            ]);
            $produit->syncStockDepuisLots();
        }

        return redirect()->route('admin.produits.index')->with('success', 'Produit ajouté avec succès !');
    }

    //  AFFICHER LE FORMULAIRE DE MODIFICATION
    public function edit($id)
    {
        $produit = Produit::with(['lots' => fn ($q) => $q->orderBy('date_peremption')])->findOrFail($id);

        return view('admin.produits.edit', compact('produit'));
    }

    //  METTRE À JOUR LE PRODUIT
    public function update(UpdateProduitRequest $request, $id)
    {
        $data = $request->validated();

        $produit = Produit::findOrFail($id);

        // Même astuce pour la mise à jour
        $data['sur_ordonnance'] = $request->has('sur_ordonnance');

        if ($request->hasFile('image')) {
            if ($produit->image) {
                Storage::disk('public')->delete($produit->image);
            }
            $data['image'] = $request->file('image')->store('produits', 'public');
        }

        $produit->update($data);

        return redirect()->route('admin.produits.index')->with('success', 'Produit modifié avec succès !');
    }

    //  SUPPRIMER
    public function destroy($id)
    {
        Produit::findOrFail($id)->delete();

        return back()->with('success', 'Produit supprimé.');
    }

    // RÉCEPTIONNER UN NOUVEAU LOT (ajoute du stock avec sa propre date de péremption)
    public function storeLot(Request $request, Produit $produit)
    {
        $validated = $request->validate([
            'quantite' => 'required|integer|min:1',
            'date_peremption' => 'required|date',
            'numero_lot' => 'nullable|string|max:100',
        ]);

        $produit->lots()->create($validated);
        $produit->syncStockDepuisLots();

        return back()->with('success', 'Lot ajouté avec succès.');
    }

    // SUPPRIMER UN LOT (erreur de saisie, lot jeté, etc.)
    public function destroyLot(Produit $produit, Lot $lot)
    {
        abort_unless($lot->produit_id === $produit->id, 404);

        $lot->delete();
        $produit->syncStockDepuisLots();

        return back()->with('success', 'Lot supprimé.');
    }
}
