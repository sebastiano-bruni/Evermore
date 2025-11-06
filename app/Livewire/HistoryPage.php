<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HistoryPage extends Component
{
    public $visits = []; // Conterrà le visite da mostrare

    public function mount()
    {
        // Carica tutte le visite dell'utente, includendo i dati del profilo associato
        $this->visits = Auth::user()->visits()
            ->with('commemorativeProfile') // Mentre recuperi le visite, carica subito anche i dati del commemorativeProfile associato a ciascuna visita
            ->whereNotNull('latitude') // Mostra solo visite con GPS
            ->latest() // Ordina dalla più recente
            ->get()
            ->map(function ($visit) {
                // Formatta i dati per renderli facili da usare in JS
                return [
                    'lat' => $visit->latitude,
                    'lng' => $visit->longitude,
                    'name' => $visit->commemorativeProfile->first_name . ' ' . $visit->commemorativeProfile->last_name,
                    'date' => $visit->created_at->format('d/m/Y H:i')
                ];
            });
    }

    public function render()
    {
        return view('livewire.history-page')
            ->layout('layouts.app');
    }
}
