<?php

namespace App\Livewire;

use App\Mail\PostVisitReminder;
use App\Models\CommemorativeProfile;
use App\Models\Visit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; // Per fare chiamate API
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\Component;

class ChatPage extends Component
{
    public CommemorativeProfile $profile;
    public array $messages = []; // Qui salvo la cronologia della chat
    public string $newMessage = ''; // Il testo scritto dall'utente
    public bool $chatEnded = false;
    public bool $emailSent = false;
    public ?Visit $currentVisit;


    /**
     * "Mount" viene chiamato quando la pagina si carica.
     * Riceve il profilo dall'URL (grazie alla rotta)
     */
    public function mount(CommemorativeProfile $profile)
    {
        $this->profile = $profile;

        // Implemento RF14: Tracciamento Visita
        $this->trackVisit();

        // Avvia la conversazione con il "greet" iniziale
        $this->greetRasa();

        $this->dispatch('request-location');   //da vedere se toglierlo perché funziona anche senza
    }

    /**
     * Invia il saluto iniziale a Rasa per ottenere il primo messaggio
     */
    public function greetRasa()
    {
        $rasaUrl = config('app.rasa_url', env('RASA_URL'));
        $personId = $this->profile->rasa_person_id; // es. "marco_rossi"

        // Comando: /greet{"person_id": "marco_rossi"}
        $response = Http::post($rasaUrl, [
            'sender' => Auth::id(), // Uso l'ID utente come ID sessione
            'message' => '/greet{"person_id": "' . $personId . '"}'
        ]);

        if ($response->successful()) {
            // Aggiunge i messaggi di risposta di Rasa alla chat
            foreach ($response->json() as $botMessage) {
                $this->messages[] = ['sender' => 'bot', 'text' => $botMessage['text']];
            }
        } else {
            $this->messages[] = ['sender' => 'bot', 'text' => 'Errore: non riesco a connettermi al chatbot.'];
        }
    }

    /**
     * Chiamato quando l'utente invia un messaggio
     */
    public function sendMessage()
    {
        $rasaUrl = config('app.rasa_url', env('RASA_URL'));
        $userMessage = $this->newMessage;

        // 1. Aggiungi il messaggio dell'utente alla chat
        $this->messages[] = ['sender' => 'user', 'text' => $userMessage];

        // 2. Invia il messaggio a Rasa
        $response = Http::post($rasaUrl, [
            'sender' => Auth::id(),
            'message' => $userMessage
        ]);

        // 3. Aggiunge la risposta (o le risposte) di Rasa
        if ($response->successful() && $response->json()) {
            foreach ($response->json() as $botMessage) {
                // 1. Mostra il messaggio SOLO se c'è del testo
                if (isset($botMessage['text']) && !empty($botMessage['text'])) {
                    $this->messages[] = ['sender' => 'bot', 'text' => $botMessage['text']];
                }

                // 2. Controlla il segnale di chiusura (indipendentemente dal testo)
                if (isset($botMessage['custom']['action']) && $botMessage['custom']['action'] === 'end_session') {
                    $this->chatEnded = true;
                    $this->sendPostVisitEmail();
                }
            }
        } else {
            // Messaggio di default se Rasa non risponde
            $this->messages[] = ['sender' => 'bot', 'text' => '...'];
        }

        // 4. Svuota la casella di testo
        $this->newMessage = '';
    }

    /**
     * Termina la chat a causa del timer scaduto.
     */
    public function endChatByTimer()
    {
        // 1. Controlla se la chat è già finita (per sicurezza)
        if ($this->chatEnded) {
            return;
        }

        // 2. Imposta lo stato "finito"
        $this->chatEnded = true;

        // 3. Aggiunge un messaggio di sistema alla chat
        $this->messages[] = [
            'sender' => 'bot',
            'text' => 'Sessione terminata. Il tempo a disposizione è scaduto.'
        ];

        $this->sendPostVisitEmail();
    }

    /**
     * Invia l'email post-visita
     */
    private function sendPostVisitEmail()
    {
        // Controlla se la chat è finita e se l'email non è già stata inviata
        if ($this->chatEnded && !$this->emailSent) {

            // Invia l'email all'utente loggato
            Mail::to(Auth::user())->send(new PostVisitReminder(Auth::user(), $this->profile));

            // Imposta il flag per non inviarla di nuovo
            $this->emailSent = true;
        }
    }

    /**
     * Salva la visita nel database
     */
    private function trackVisit()
    {
        // Salva la visita nella proprietà della classe
        $this->currentVisit = Visit::create([
            'user_id' => Auth::id(),
            'commemorative_profile_id' => $this->profile->id,
        ]);
    }

    /**
     * Ascolta l'evento 'location-captured' da JS e salva le coordinate
     */
    #[On('location-captured')]
    public function saveLocation($latitude, $longitude)
    {
        if ($this->currentVisit) {
            $this->currentVisit->update([
                'latitude' => $latitude,
                'longitude' => $longitude,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.chat-page')
            ->layout('layouts.app'); // Usa il layout principale
    }
}
