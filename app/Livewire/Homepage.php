<?php

namespace App\Livewire;

use Livewire\Component;

class Homepage extends Component
{
    public function render()
    {
        // MODIFICA CHIAVE: Usiamo il nuovo layout 'public' invece di quello di default 'app'
        return view('livewire.homepage')
            ->layout('layouts.public');
    }
}

