<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class HistoryPage extends Component
{
    public $visits;

    public function mount()
    {
        // In una versione futura, questi dati arriveranno dal database
        // E.g., $this->visits = Auth::user()->visits()->latest()->get();

        // Per ora, usiamo dati di esempio
        $this->visits = collect([
            (object)['profile_name' => 'Valentino Bruni', 'created_at' => now()->subDays(2)],
            (object)['profile_name' => 'Marco Rossi', 'created_at' => now()->subDays(10)],
            (object)['profile_name' => 'Anna Neri', 'created_at' => now()->subDays(35)],
        ]);
    }

    public function render()
    {
        return view('livewire.history-page');
    }
}
