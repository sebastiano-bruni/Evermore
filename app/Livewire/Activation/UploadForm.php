<?php

namespace App\Livewire\Activation;

use App\Models\CommemorativeProfile;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadForm extends Component
{
    use WithFileUploads;

    public CommemorativeProfile $profile;
    #[Validate('required|file|mimes:pdf,jpg,png|max:10240')]
    public $certificateUpload;
    #[Validate('required|date|before_or_equal:today')]
    public $death_date;

    public function mount()
    {
        $this->death_date = $this->profile->death_date ? $this->profile->death_date->format('Y-m-d') : '';
    }

    public function activateProfile()
    {
        $this->validate();

        $path = null;
        if ($this->certificateUpload) {
            $path = $this->certificateUpload->store('certificates', 'public');
        }

        // Aggiorna il profilo
        $this->profile->update([
            'death_date' => $this->death_date,
            'death_certificate_path' => $path,
            'status' => 'active', // <-- Ho messo active così abbiamo un prototipo funzionante, in futuro verrà messa una logica per la verifica del decesso
        ]);

        $this->certificateUpload = null;

        // Forzo l'aggiornamento dell'oggetto profile
        $this->profile->refresh();

        // Emetto il segnale alla dashboard
        $this->dispatch('profile-updated');
    }

    public function render()
    {
        return view('livewire.activation.upload-form');
    }
}
