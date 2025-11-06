<div>
    {{-- Questo imposta il titolo "Dashboard" nell'intestazione del layout --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Messaggio di benvenuto base --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    Benvenuto/a! ({{ auth()->user()->name }})
                </div>
            </div>

            {{--
                SEZIONE "PROFILI DA GESTIRE"
                Questo blocco apparirà solo se sei un contatto fidato
                e hai accettato almeno un invito.
            --}}
            @if($profilesToManage->isNotEmpty())
                <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium">Profili che gestisci</h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Sei stato designato come Contatto Fidato per i seguenti profili.
                        </p>

                        <div class="mt-6 space-y-6">
                            {{-- Loop su ogni profilo che l'utente gestisce --}}
                            @foreach($profilesToManage as $contact)
                                @php
                                    $profile = $contact->commemorativeProfile;
                                    $owner = $profile ? $profile->user : null; // Controllo di sicurezza
                                @endphp

                                @if($profile)
                                    <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                                        <h4 class="text-md font-semibold text-gray-900 dark:text-gray-100">
                                            Profilo di: {{ $owner ? $owner->name : '[Utente Eliminato]' }}
                                        </h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            Stato:
                                            <span class="font-semibold
                                            @if($profile->status == 'draft') text-gray-500 @endif
                                            @if($profile->status == 'pending_activation') text-yellow-500 @endif
                                            @if($profile->status == 'active') text-green-500 @endif
                                        ">
                                            {{ ucfirst(str_replace('_', ' ', $profile->status)) }}
                                        </span>
                                        </p>

                                        {{--
                                            Include il form di attivazione (RF10)
                                            Nota: il nome del componente usa il trattino.
                                        --}}
                                        <livewire:activation.upload-form
                                            :profile="$profile"
                                            :key="$profile->id" />

                                    </div>
                                @endif
                            @endforeach
                        </div>

                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
