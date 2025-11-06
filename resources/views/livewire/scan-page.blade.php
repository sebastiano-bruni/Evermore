<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Ricerca Defunto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if ($foundProfile)
                        <div class="text-center">
                            <h3 class="text-2xl font-semibold text-green-600 dark:text-green-400">Profilo Trovato!</h3>
                            <p class="mt-2 text-lg">
                                Stai per avviare una conversazione con
                                <span class="font-bold">{{ $foundProfile->first_name }} {{ $foundProfile->last_name }}</span>
                            </p>
                            <p class="mt-1 text-sm text-gray-500">(Rasa ID: {{ $foundProfile->rasa_person_id }})</p>

                            <div class="mt-6">
                                <a href="{{ route('chat', ['profile' => $foundProfile->id]) }}"
                                   class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Avvia Conversazione
                                </a>
                            </div>

                            <button wire:click="resetScan" class="mt-4 text-sm text-gray-500 hover:underline">
                                Esegui un'altra ricerca
                            </button>
                        </div>

                    @else
                        <form wire:submit="search" class="space-y-6">
                            <h3 class="text-lg font-medium text-center">Ricerca Manuale</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 text-center">
                                Inserisci i dati che leggi sulla lapide per trovare il profilo.
                            </p>

                            <div>
                                <x-input-label for="firstName" value="Nome" />
                                <x-text-input wire:model="firstName" id="firstName" type="text" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('firstName')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="lastName" value="Cognome" />
                                <x-text-input wire:model="lastName" id="lastName" type="text" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('lastName')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="birthDate" value="Data di Nascita (AAAA-MM-GG)" />
                                <x-text-input wire:model="birthDate" id="birthDate" type="date" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('birthDate')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="deathDate" value="Data di Morte (AAAA-MM-GG)" />
                                <x-text-input wire:model="deathDate" id="deathDate" type="date" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('deathDate')" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button type="submit">Cerca Profilo</x-primary-button>
                            </div>
                        </form>
                    @endif

                    @if ($errorMessage)
                        <div class="mt-6 p-4 bg-red-100 dark:bg-red-900 border border-red-400 text-red-700 dark:text-red-300 rounded-lg">
                            <p class="font-bold">Ricerca Fallita</p>
                            <p class="text-sm">{{ $errorMessage }}</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
