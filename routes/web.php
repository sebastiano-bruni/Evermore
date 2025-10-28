<?php

use App\Livewire\Homepage;
use App\Livewire\ScanPage;
use App\Livewire\HistoryPage; // Importiamo il nuovo componente
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Homepage pubblica
Route::get('/', Homepage::class)->name('home');

// Pagine private (richiedono login)
Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', function () { // Modificato per caricare la vista direttamente
        return view('dashboard');
    })->name('dashboard');

    Route::get('scan', ScanPage::class)->name('scan');

    // NUOVA ROTTA: La nostra pagina per la cronologia
    Route::get('history', HistoryPage::class)->name('history');

    Route::get('profile', function () { // Modificato per caricare la vista direttamente
        return view('profile');
    })->name('profile');
});


require __DIR__.'/auth.php';

