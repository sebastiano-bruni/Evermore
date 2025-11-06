<?php

namespace App\Livewire;

use App\Models\CommemorativeProfile;
use Livewire\Component;

class ScanPage extends Component
{
    // 1. Campi del form
    public string $firstName = '';
    public string $lastName = '';
    public string $birthDate = '';
    public string $deathDate = '';

    // 2. Risultati
    public $foundProfile = null;
    public string $errorMessage = '';

    // Elenco degli ID dei bot Rasa
    private array $validRasaIDs = [
        'marco_rossi',
        'giulia_bianchi',
        'valentino_bruni',
        'anna_neri',
    ];

    /**
     * Esegue la ricerca quando l'utente preme "Cerca"
     */
    public function search()
    {
        $this->resetResults();

        // Validazione base
        $this->validate([
            'firstName' => 'required|string|min:2',
            'lastName' => 'required|string|min:2',
            'birthDate' => 'required|date',
            'deathDate' => 'required|date',
        ]);

        try {
            // Costruisce la query
            $query = CommemorativeProfile::query()
                ->where('status', 'active') // Cerca solo profili ATTIVI
                ->where('first_name', 'LIKE', $this->firstName)
                ->where('last_name', 'LIKE', $this->lastName)
                ->where('birth_date', $this->birthDate)
                ->where('death_date', $this->deathDate);


            $profile = $query->first();

            if ($profile) {
                // Profilo trovato. ORA controlliamo l'ID Rasa.
                if ( is_null($profile->rasa_person_id) ||
                    !in_array($profile->rasa_person_id, $this->validRasaIDs) )
                {
                    // L'ID non è valido o è nullo
                    $this->errorMessage = 'Conversazione non disponibile con questo utente. Il profilo AI non è configurato.';
                    // NON impostiamo $foundProfile, così il pulsante "Avvia" non appare
                } else {
                    // ID Valido! Mostra il risultato.
                    $this->foundProfile = $profile;
                }
            } else {
                // Profilo non trovato nel database
                $this->errorMessage = 'Nessun profilo attivo trovato con i dati inseriti. Controlla che i dati siano corretti.';
            }

        } catch (\Exception $e) {
            $this->errorMessage = 'Si è verificato un errore durante la ricerca.';
        }
    }

    /**
     * Resetta i risultati per una nuova ricerca
     */
    public function resetScan()
    {
        $this->resetResults();
        $this->firstName = '';
        $this->lastName = '';
        $this->birthDate = '';
        $this->deathDate = '';
    }

    private function resetResults()
    {
        $this->foundProfile = null;
        $this->errorMessage = '';
    }

    public function render()
    {
        return view('livewire.scan-page')
            ->layout('layouts.app');
    }
}
