<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Avvia Conversazione
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- Sezione Fotocamera -->
            <div class="bg-gray-800 border border-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-white">Inquadra la Lapide</h3>
                <p class="mt-1 text-sm text-gray-400">Centra il nome, cognome e le date nell'area sottostante per avviare il riconoscimento.</p>

                {{-- Placeholder per la vista della fotocamera --}}
                <div class="mt-4 aspect-video bg-black rounded-md flex items-center justify-center">
                    <p class="text-gray-500">Anteprima fotocamera non disponibile</p>
                </div>

                <button class="mt-6 w-full text-center px-6 py-3 rounded-md bg-yellow-500 text-gray-900 font-semibold hover:bg-yellow-400 transition-colors">
                    Avvia Scansione
                </button>
            </div>

            <!-- Sezione Chat -->
            <div class="bg-gray-800 border border-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-white">Conversazione</h3>
                <p class="mt-1 text-sm text-gray-400">Una volta avvenuto il riconoscimento, la chat si attiverà qui.</p>

                {{-- Placeholder per il widget della chat --}}
                <div class="mt-4 h-96 bg-gray-900 rounded-md flex items-center justify-center">
                    <p class="text-gray-500">La chat apparirà qui...</p>
                </div>
            </div>

        </div>
    </div>
</div>
