<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrdonnanceController extends Controller
{
    // Affiche l'ordonnance d'une commande : réservé au client propriétaire ou au gérant
    public function show(Commande $commande): StreamedResponse
    {
        $user = Auth::user();

        abort_unless(
            $commande->image_ordonnance && ($user->role === 'gerant' || $commande->user_id === $user->id),
            403
        );

        abort_unless(Storage::disk('local')->exists($commande->image_ordonnance), 404);

        return Storage::disk('local')->response($commande->image_ordonnance);
    }
}
