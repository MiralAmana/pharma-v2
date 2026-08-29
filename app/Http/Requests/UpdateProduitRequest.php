<?php

namespace App\Http\Requests;

use App\Models\Produit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProduitRequest extends FormRequest
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
            'stock' => 'required|integer|min:0',
            'date_peremption' => 'required|date',
        ];
    }
}
