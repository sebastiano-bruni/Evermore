<?php

namespace App\Livewire\CommemorativeProfile;

// Importa tutte le classi necessarie
use App\Models\CommemorativeProfile;
use App\Models\TrustedContact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TrustedContactInvitation;
use Livewire\Attributes\On;
use Illuminate\Support\Collection;
use Livewire\Component;

class ManageContacts extends Component
{
    public ?CommemorativeProfile $profile;
    public string $emailToInvite = '';

    // Usiamo una proprietà pubblica per la lista
    public Collection $contacts;

    public function mount(): void
    {
        $this->profile = Auth::user()->commemorativeProfile()->first();
        $this->loadContacts(); // Carica i contatti all'inizio
    }

    #[On('profile-saved')]
    public function refreshProfile()
    {
        $this->profile = Auth::user()->commemorativeProfile()->first();
        $this->loadContacts(); // Ricarica anche qui
    }

    /**
     * Funzione helper per caricare i contatti "freschi"
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

        // FORZA L'AGGIORNAMENTO
        $this->loadContacts();
    }

    public function removeContact(int $contactId): void
    {
        if (!$this->profile) { return; }
        $contact = $this->profile->trustedContacts()->find($contactId);
        if ($contact) {
            $contact->delete();
        }

        // FORZA L'AGGIORNAMENTO
        $this->loadContacts();
    }

    public function render()
    {
        // Restituisce la vista corretta
        return view('livewire.commemorative-profile.manage-contacts');
    }
}
