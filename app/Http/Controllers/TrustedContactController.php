<?php

namespace App\Http\Controllers;

use App\Models\TrustedContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrustedContactController extends Controller
{
    /**
     * Gestisce l'accettazione di un invito.
     */
    public function accept(Request $request, TrustedContact $contact)
    {
        $user = Auth::user(); // Prende l'utente loggato

        // --- Iniziano i controlli logici ---

        // 1. Controlla che l'invito sia ancora "pending"
        if ($contact->status !== 'pending') {
            // Se non è pending, reindirizza con un messaggio informativo
            return redirect()->route('dashboard')
                ->with('status', 'Questo invito è già stato gestito in precedenza.');
        }

        // 2. Controlla che l'utente loggato sia quello invitato
        // Usiamo 'strtolower' per sicurezza, per evitare problemi Maiuscole/minuscole
        if (strtolower($user->email) !== strtolower($contact->email)) {
            // L'utente sbagliato ha cliccato il link
            return redirect()->route('dashboard')
                ->with('status', 'Errore: Questo invito non è destinato a te.');
        }

        // --- TUTTO OK! ACCETTIAMO L'INVITO ---

        // 3. Aggiorna il record nel database
        $contact->status = 'accepted';
        $contact->trusted_user_id = $user->id; // Collega l'ID utente!
        $contact->save();

        // 4. Rimanda alla Dashboard con un messaggio di successo
        return redirect()->route('dashboard')
            ->with('status', 'Invito accettato! Ora sei un Contatto Fidato.');
    }
}
