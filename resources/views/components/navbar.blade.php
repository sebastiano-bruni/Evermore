<header class="w-full py-4 px-6 sm:px-10 flex justify-between items-center bg-gray-900/80 backdrop-blur-sm sticky top-0 z-50 border-b border-gray-800">
    <a href="{{ route('home') }}" wire:navigate>
        <h1 class="text-2xl font-bold gold-gradient-text">Evermore</h1>
    </a>
    <nav class="hidden md:flex items-center space-x-6">
        <a href="/#features" class="hover:text-yellow-400 transition-colors">Come Funziona</a>
        <a href="/#profile" class="hover:text-yellow-400 transition-colors">Il Tuo Profilo</a>
        <a href="/#contact" class="hover:text-yellow-400 transition-colors">Contatti</a>
    </nav>
    <div class="flex items-center space-x-3">
        {{-- Logica per mostrare i pulsanti corretti --}}
        @auth
            {{-- Se l'utente è loggato, mostra il link alla Dashboard --}}
            <a href="{{ url('/dashboard') }}" class="text-sm px-4 py-2 rounded-md bg-yellow-500 text-gray-900 font-semibold hover:bg-yellow-400 transition-colors">Dashboard</a>
        @else
            {{-- Se l'utente è un ospite, mostra Accedi e Registrati --}}
            <a href="{{ route('login') }}" class="text-sm px-4 py-2 rounded-md hover:bg-gray-800 transition-colors" wire:navigate>Accedi</a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="text-sm px-4 py-2 rounded-md bg-yellow-500 text-gray-900 font-semibold hover:bg-yellow-400 transition-colors" wire:navigate>Registrati</a>
            @endif
        @endauth
    </div>
</header>

