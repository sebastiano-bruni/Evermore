<?php

use App\Http\Controllers\TrustedContactController;
use App\Livewire\ChatPage;
use App\Livewire\Homepage;
use App\Livewire\Dashboard;
use App\Livewire\ScanPage;
use App\Livewire\HistoryPage;
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
    Route::get('dashboard', Dashboard::class)->name('dashboard');

    // Pagina per la scannerizzazione
    Route::get('scan', ScanPage::class)->name('scan');

    // Pagina per la cronologia
    Route::get('history', HistoryPage::class)->name('history');

    Route::get('profile', function () {
        return view('profile');
    })->name('profile');

    // 'chat/{profile}' riceve l'ID del profilo trovato
    Route::get('chat/{profile}', ChatPage::class)->name('chat');
});



Route::get('/invitation/accept/{contact}', [TrustedContactController::class, 'accept'])
    ->middleware(['auth', 'signed']) // 'auth' = devi essere loggato, 'signed' = il link è sicuro
    ->name('contacts.accept');


require __DIR__.'/auth.php';

