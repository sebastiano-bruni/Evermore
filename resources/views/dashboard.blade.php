<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 border border-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <h3 class="text-2xl font-bold">Bentornato, {{ Auth::user()->name }}!</h3>
                    <p class="mt-2 text-gray-400">Questo è il tuo spazio personale. Da qui puoi gestire le tue conversazioni e i tuoi ricordi.</p>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Card per Scannerizzare -->
                <div class="bg-gray-800 border border-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col items-center text-center hover:bg-gray-700/50 transition-colors">
                    <div class="flex justify-center items-center mb-4 w-16 h-16 mx-auto bg-gray-700 rounded-full">
                        <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h-1m-1 6v-1M4 12H3m17 0h-1m-1-6l-1-1M6 6l-1-1M4 6l1-1m14 14l-1-1M6 20l1-1M12 4v1m6 11h-1m-1 6v-1M4 12H3m17 0h-1m-1-6l-1-1M6 6l-1-1M4 6l1-1m14 14l-1-1M6 20l1-1M12 9a3 3 0 100 6 3 3 0 000-6z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-white">Avvia una Conversazione</h4>
                    <p class="mt-2 text-gray-400 flex-grow">Vai alla sezione di scansione per connetterti con un ricordo e iniziare un nuovo dialogo.</p>
                    {{-- MODIFICA: Aggiunto il link alla rotta 'scan' --}}
                    <a href="{{ route('scan') }}" wire:navigate class="mt-6 w-full text-center px-6 py-2 rounded-md bg-yellow-500 text-gray-900 font-semibold hover:bg-yellow-400 transition-colors">
                        Scannerizza
                    </a>
                </div>

                <!-- Card per la Cronologia -->
                <div class="bg-gray-800 border border-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col items-center text-center hover:bg-gray-700/50 transition-colors">
                    <div class="flex justify-center items-center mb-4 w-16 h-16 mx-auto bg-gray-700 rounded-full">
                        <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-white">Cronologia Visite</h4>
                    <p class="mt-2 text-gray-400 flex-grow">Rivedi le tue conversazioni passate, i luoghi che hai visitato e i ricordi che hai condiviso.</p>
                    <a href="{{ route('history') }}" wire:navigate class="mt-6 w-full text-center px-6 py-2 rounded-md bg-gray-700 text-white font-semibold hover:bg-gray-600 transition-colors">
                        Visualizza Cronologia
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

