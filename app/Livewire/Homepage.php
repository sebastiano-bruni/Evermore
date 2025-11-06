<?php

namespace App\Livewire;

use Livewire\Component;

class Homepage extends Component
{
    public function render()
    {
        // Uso il layout public
        return view('livewire.homepage')
            ->layout('layouts.public');
    }
}

