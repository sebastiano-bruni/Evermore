<?php

use App\Models\CommemorativeProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[layout('layouts.app')] class extends Component {
    // Dati dal modello User (Breeze)
    public string $email = '';

    // Dati dal nostro modello CommemorativeProfile
    public ?CommemorativeProfile $profile;
    public string $first_name = '';
    public string $last_name = '';
    public string $birth_date = '';
    public string $biography = '';
    public string $passions = '';
    public string $rasa_person_id = '';

    /**
     * Logica "mount": carica i dati da ENTRAMBI i modelli
     */
    public function mount(): void
    {
        $user = Auth::user();

        // Carica i dati dell'account
        $this->email = $user->email;

        // Carica i dati del profilo commemorativo
        $this->profile = $user->commemorativeProfile()->firstOrNew();
        $this->first_name = $this->profile->first_name ?? '';
        $this->last_name = $this->profile->last_name ?? '';
        $this->birth_date = $this->profile->birth_date ?
            (is_string($this->profile->birth_date) ? $this->profile->birth_date : $this->profile->birth_date->format('Y-m-d'))
            : '';
        $this->biography = $this->profile->biography ?? '';
        $this->passions = $this->profile->passions ?? '';
        $this->rasa_person_id = $this->profile->rasa_person_id ?? '';
    }

    /**
     * Salva le modifiche su ENTRAMBI i modelli
     */
    public function saveProfile(): void
    {
        $user = Auth::user();

        // Valida tutti i campi
        $validated = $this->validate([
            // Campi CommemorativeProfile
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'biography' => 'nullable|string',
            'passions' => 'nullable|string',
            'rasa_person_id' => 'nullable|string|max:100',
        ]);


        // 2. Salva i dati sul modello CommemorativeProfile
        $this->profile->user_id = $user->id;
        $this->profile->fill([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'birth_date' => $this->birth_date,
            'biography' => $this->biography,
            'passions' => $this->passions,
            'rasa_person_id' => $this->rasa_person_id,
        ]);
        $this->profile->save();

        // Invia l'evento "salvato"
        $this->dispatch('profile-saved');
    }
}; ?>

<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Informazioni Profilo
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Gestisci le informazioni del tuo account e del tuo profilo commemorativo.
        </p>
    </header>

    <form wire:submit="saveProfile" class="mt-6 space-y-6">

        <div>
            <x-input-label for="email" value="Email Account"/>
            <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full" required disabled/>
            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
        </div>

        <div class="border-t border-gray-200 dark:border-gray-700 my-6"></div>

        <header>
            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100">
                Dati Commemorativi (per OCR)
            </h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Questi dati saranno usati per il riconoscimento della lapide e per generare l'esperienza.
            </p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="first_name" value="Nome (come sulla lapide)"/>
                <x-text-input wire:model="first_name" id="first_name" name="first_name" type="text"
                              class="mt-1 block w-full" required/>
                <x-input-error :messages="$errors->get('first_name')" class="mt-2"/>
            </div>
            <div>
                <x-input-label for="last_name" value="Cognome (come sulla lapide)"/>
                <x-text-input wire:model="last_name" id="last_name" name="last_name" type="text"
                              class="mt-1 block w-full" required/>
                <x-input-error :messages="$errors->get('last_name')" class="mt-2"/>
            </div>
        </div>

        <div>
            <x-input-label for="birth_date" value="Data di Nascita (come sulla lapide)"/>
            <x-text-input wire:model="birth_date" id="birth_date" name="birth_date" type="date"
                          class="mt-1 block w-full" required/>
            <x-input-error :messages="$errors->get('birth_date')" class="mt-2"/>
        </div>

        <div>
            <x-input-label for="biography" value="Biografia e Momenti Salienti"/>
            <textarea wire:model="biography" id="biography"
                      class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                      rows="5"></textarea>
            <x-input-error :messages="$errors->get('biography')" class="mt-2"/>
        </div>

        <div>
            <x-input-label for="passions" value="Passioni (separate da virgola)"/>
            <x-text-input wire:model="passions" id="passions" name="passions" type="text" class="mt-1 block w-full"
                          placeholder="Es. Calcio, Viaggi, Lettura"/>
            <x-input-error :messages="$errors->get('passions')" class="mt-2"/>
        </div>

        <div class="border-t border-gray-200 dark:border-gray-700 my-6"></div>

        <header>
            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100">
                Configurazione Chatbot
            </h3>
        </header>

        <div>
            <x-input-label for="rasa_person_id" value="Rasa Person ID (es. marco_rossi)" />
            <x-text-input wire:model="rasa_person_id" id="rasa_person_id" name="rasa_person_id" type="text" class="mt-1 block w-full" placeholder="es. marco_rossi" />
            <x-input-error :messages="$errors->get('rasa_person_id')" class="mt-2" />
        </div>


        <div class="flex items-center gap-4">
            <x-primary-button>Salva Profilo</x-primary-button>
            <x-action-message class="me-3" on="profile-saved">
                Salvato.
            </x-action-message>
        </div>
    </form>
</section>
