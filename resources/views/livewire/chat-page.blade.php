<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Conversazione con {{ $profile->first_name }} {{ $profile->last_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class.="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex flex-col h-[70vh]"> {{-- Altezza fissa --}}

                            <div class.="flex-grow p-6 space-y-4 overflow-y-auto">
                                @foreach($messages as $message)
                                    <div class="flex
                                        @if($message['sender'] == 'user')
                                            justify-end
                                        @else
                                            justify-start
                                        @endif
                                    ">
                                        <div class.="max-w-xs lg:max-w-md px-4 py-2 rounded-lg
                                            @if($message['sender'] == 'user')
                                                bg-indigo-600 text-white
                                            @else
                                                bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                            @endif
                                        ">
                                            {{ $message['text'] }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="p-4 border-t border-gray-200 dark:border-gray-700">

                                @if(!$chatEnded)
                                    <form wire:submit="sendMessage" class="flex items-center">
                                        <x-text-input
                                            wire:model="newMessage"
                                            wire:key="chat-input"
                                            class="flex-grow"
                                            placeholder="Scrivi il tuo messaggio..."
                                            autocomplete="off"
                                            required />
                                        <x-primary-button type="submit" class.="ml-4"
                                                          wire:key="chat-submit-button">
                                            Invia
                                        </x-primary-button>
                                    </form>

                                @else
                                    <div class="text-center p-4">
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Conversazione terminata.</p>
                                        <a href="{{ route('dashboard') }}"
                                           class="mt-2 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                            Torna alla Dashboard
                                        </a>
                                    </div>
                                @endif
                            </div>

                        </div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        // Lo script viene eseguito OGNI VOLTA che la pagina chat viene caricata
        document.addEventListener('livewire:navigated', () => {

            // --- 1. LOGICA DEL TIMER ---
            const chatDuration = 10 * 60 * 1000; // 10 min (o 30 * 1000 per 30 sec)

            const timer = setTimeout(() => {
            @this.call('endChatByTimer');
            }, chatDuration);

            document.addEventListener('livewire:navigating', () => {
                clearTimeout(timer);
            }, { once: true });


            // --- 2. LOGICA DI GEOLOCALIZZAZIONE ---

            // Controlla se il browser supporta la geolocalizzazione
            if (navigator.geolocation) {
                // Chiede la posizione
                navigator.geolocation.getCurrentPosition((position) => {
                    // Posizione ottenuta
                    let lat = position.coords.latitude;
                    let lon = position.coords.longitude;

                    // Invia le coordinate al metodo 'saveLocation' in PHP
                @this.call('saveLocation', lat, lon);

                }, (error) => {
                    // L'utente ha negato il permesso o c'è stato un errore
                    console.warn('Geolocalizzazione fallita: ' + error.message);
                    // Invia coordinate nulle se fallisce
                @this.call('saveLocation', null, null);
                });
            } else {
                console.warn('Geolocalizzazione non supportata da questo browser.');
                // Invia coordinate nulle se non supportata
            @this.call('saveLocation', null, null);
            }

        });
    </script>
@endpush
