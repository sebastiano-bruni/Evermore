<?php

namespace App\Livewire;

use Livewire\Attributes\Layout; // Importante aggiungere questa riga
use Livewire\Component;


#[Layout('layouts.app')]
class ScanPage extends Component
{
    public function render()
    {
        return view('livewire.scan-page');
    }
}
