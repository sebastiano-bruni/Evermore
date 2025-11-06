<div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">

    @if (session('activation_saved'))
        <div class="my-3 font-medium text-sm text-green-600 dark:text-green-400">
            {{ session('activation_saved') }}
        </div>
    @endif


    @if($profile->status == 'active')
        <p class="text-sm font-medium text-green-600 dark:text-green-400">Questo profilo è già attivo.</p>

    @elseif($profile->status == 'pending_activation')
        <p class="text-sm font-medium text-yellow-600 dark:text-yellow-400">Questo profilo è in attesa di approvazione finale.</p>

    @else
        <h4 class="text-md font-medium text-gray-900 dark:text-gray-100">
            Attiva Profilo (RF10)
        </h4>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Per attivare il profilo, inserisci la data di decesso e carica il certificato (illustrativo).
        </p>

        <form wire:submit="activateProfile" class="mt-4 space-y-4">
            <div>
                <x-input-label for="death_date" value="Data di Decesso" />
                <x-text-input wire:model="death_date" id="death_date" type="date" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('death_date')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="certificateUpload" value="Certificato di Morte (PDF, JPG, PNG - Max 10MB)" />
                <input wire:model="certificateUpload" type="file" id="certificateUpload"
                       class="mt-1 block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-md file:border-0
                              file:text-sm file:font-semibold
                              file:bg-indigo-50 dark:file:bg-indigo-900
                              file:text-indigo-700 dark:file:text-indigo-300
                              hover:file:bg-indigo-100" />
                <x-input-error :messages="$errors->get('certificateUpload')" class="mt-2" />
            </div>

            <x-primary-button type="submit">Attiva Profilo</x-primary-button>
        </form>
    @endif

</div>
