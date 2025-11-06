<?php

use App\Models\CommemorativeProfile;
use App\Models\TrustedContact;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\TrustedContactInvitation;
use Livewire\Attributes\On;
use Illuminate\Support\Collection;

new #[layout('layouts.app')] class extends Component
{
    public ?CommemorativeProfile $profile;
    public string $emailToInvite = '';

    // 1. Usiamo una proprietà pubblica per la lista
    public Collection $contacts;

    public function mount(): void
    {
        $this->profile = Auth::user()->commemorativeProfile()->first();
        $this->loadContacts(); // 2. Carica i contatti all'inizio
    }

    #[On('profile-saved')]
    public function refreshProfile()
    {
        $this->profile = Auth::user()->commemorativeProfile()->first();
        $this->loadContacts(); // Ricarica anche qui
    }

    /**
     * 3. Funzione helper per caricare i contatti "freschi"
     */
    public function loadContacts(): void
    {
        $this->contacts = $this->profile
            ? $this->profile->trustedContacts()->latest()->get()
            : collect();
    }

    public function inviteContact(): void
    {
        if (!$this->profile) return;

        $this->validate([ 'emailToInvite' => 'required|email|max:255', ]);

        if ($this->emailToInvite === Auth::user()->email) {
            session()->flash('contact_error', 'Non puoi invitare te stesso.');
            return;
        }
        $existing = $this->profile->trustedContacts()->where('email', $this->emailToInvite)->exists();
        if ($existing) {
            session()->flash('contact_error', 'Hai già invitato questo utente.');
            return;
        }

        $newContact = $this->profile->trustedContacts()->create([
            'email' => $this->emailToInvite, 'status' => 'pending',
        ]);
        Mail::to($newContact->email)->send(new TrustedContactInvitation(Auth::user(), $newContact));

        session()->flash('contact_saved', 'Invito inviato a ' . $this->emailToInvite);
        $this->emailToInvite = '';

        // 4. FORZA L'AGGIORNAMENTO
        $this->loadContacts();
    }

    public function removeContact(int $contactId): void
    {
        if (!$this->profile) { return; }

        $contact = $this->profile->trustedContacts()->find($contactId);

        if ($contact) {
            $contact->delete();
        }

        // 5. FORZA L'AGGIORNAMENTO
        $this->loadContacts();
    }

    // 6. Rimuoviamo il metodo with() perché gestiamo la lista manualmente
}; ?>

<div>
    @if($profile)
        <section class="space-y-6">
            <header>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Contatti Fidati (RF6)
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Invita le persone che potranno attivare il tuo profilo commemorativo.
                </p>
            </header>

            @if (session('contact_saved'))
                <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ session('contact_saved') }}
                </div>
            @endif
            @if (session('contact_error'))
                <div class="mb-4 font-medium text-sm text-red-600 dark:text-red-400">
                    {{ session('contact_error') }}
                </div>
            @endif

            <form wire:submit="inviteContact" class="mt-6 flex items-center gap-4">
                <div class="flex-grow">
                    <x-input-label for="emailToInvite" value="Email del Contatto" class="sr-only" />
                    <x-text-input wire:model="emailToInvite" id="emailToInvite" type="email" class="mt-1 block w-full" placeholder="email@esempio.com" required />
                    <x-input-error :messages="$errors->get('emailToInvite')" class="mt-2" />
                </div>
                <x-primary-button>Invita</x-primary-button>
            </form>

            <div class="mt-6 space-y-4">
                <h3 class="text-md font-medium text-gray-900 dark:text-gray-100">
                    I tuoi Contatti
                </h3>
                <div class="divide-y divide-gray-200 dark:divide-gray-700">

                    @forelse ($contacts as $contact)
                        <div wire:key="contact-{{ $contact->id }}" class="flex items-center justify-between py-3">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $contact->email }}</p>
                                <p class="text-xs text-gray-500">
                                    Stato:
                                    @if($contact->status == 'pending')
                                        <span class="font-semibold text-yellow-600">In attesa di accettazione</span>
                                    @else
                                        <span class="font-semibold text-green-600">Accettato</span>
                                    @endif
                                </p>
                            </div>
                            <x-danger-button
                                wire:click="removeContact({{ $contact->id }})"
                                onclick="if (!confirm('Sei sicuro di voler rimuovere questo contatto?')) { event.stopImmediatePropagation(); }"
                            >
                                Rimuovi
                            </x-danger-button>
                        </div>
                    @empty
                        <p class="py-3 text-sm text-gray-500">Non hai ancora invitato nessun contatto fidato.</p>
                    @endforelse

                </div>
            </div>
        </section>

    @else
        <section class="space-y-6">
            <header>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Contatti Fidati (RF6)
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Per invitare i contatti, devi prima <span class="font-bold">salvare le informazioni del tuo profilo</span> nel pannello qui sopra.
                </p>
            </header>
        </section>
    @endif
</div>
