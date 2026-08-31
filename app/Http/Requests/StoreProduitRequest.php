<?php

namespace App\Http\Requests;

use App\Models\Produit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProduitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Déjà filtré par le middleware 'admin' sur la route.
    }

    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'categorie' => ['required', Rule::in(Produit::CATEGORIES)],
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            // Le stock ne se saisit plus directement : un produit démarre avec un premier lot
            // (0 si on ne fait que créer la fiche avant réception de la marchandise).
            'stock_initial' => 'required|integer|min:0',
            // 'nullable' court-circuite les règles suivantes (y compris une closure) dès que la
            // valeur est vide : on ne peut donc pas rendre la date conditionnellement requise en
            // gardant 'nullable' à côté. On construit la règle dynamiquement à la place.
            'date_peremption_initiale' => (int) $this->input('stock_initial') > 0
                ? 'required|date'
                : 'nullable|date',
        ];
    }
}
