<?php

namespace App\Livewire;

use App\Models\TrustedContact;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Dashboard extends Component
{

    /**
     * Ascolta l'evento 'profile-updated' inviato dal figlio.
     * La sua sola presenza costringe Livewire a
     * ri-eseguire il metodo render() del genitore.
     */
    #[On('profile-updated')]
    public function refreshDashboardData()
    {
        // Questo metodo può essere vuoto.
        // Quando viene chiamato dall'evento,
        // Livewire rieseguirà automaticamente render()
        // e ricaricherà i dati $profilesToManage freschi.
    }


    /**
     * Il metodo render() viene chiamato per disegnare la pagina.
     * Qui carichiamo i dati necessari.
     */
    public function render()
    {
        $user = Auth::user();

        // Cerca tutti gli inviti 'accettati' che
        // appartengono all'utente che è attualmente loggato.
        $profilesToManage = TrustedContact::where('trusted_user_id', $user->id)
            ->where('status', 'accepted')
            ->with('commemorativeProfile.user') // Carica i dati del profilo e del suo proprietario
            ->get();

        // Passa i profili trovati alla vista
        return view('livewire.dashboard', [
            'profilesToManage' => $profilesToManage,
        ])
            ->layout('layouts.app'); // Usa il layout principale
    }
}
