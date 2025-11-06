<?php

use App\Models\CommemorativeProfile;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On; // Serve per "ascoltare" l'evento

new #[layout('layouts.app')] class extends Component
{
    use WithFileUploads;

    public ?CommemorativeProfile $profile;

    #[Validate('nullable|video|mimes:mp4,mov,wmv,avi|max:102400')]      // in realtà il server ne consente al massimo 8/20MB
    public $videoMessageUpload;

    #[Validate('nullable|image|mimes:jpeg,png,jpg,gif|max:10240')]
    public $photoUpload;

    public function mount(): void
    {
        // Carica il primo
        $this->profile = Auth::user()->commemorativeProfile()->first();
    }

    // "ascolta" il salvataggio del primo pannello
    #[On('profile-saved')]
    public function refreshProfile()
    {
        $this->profile = Auth::user()->commemorativeProfile()->first();
    }

    public function saveVideoMessage(): void
    {
        $this->validateOnly('videoMessageUpload');
        $path = $this->videoMessageUpload->store('media_files', 'public');
        $this->profile->media()->create([
            'type' => 'video_message',
            'file_path' => $path,
            'title' => $this->videoMessageUpload->getClientOriginalName(),
        ]);
        $this->videoMessageUpload = null;
        session()->flash('media_saved', 'Video-messaggio caricato.');
    }

    public function savePhoto(): void
    {
        $this->validateOnly('photoUpload');
        $path = $this->photoUpload->store('media_files', 'public');
        $this->profile->media()->create([
            'type' => 'photo',
            'file_path' => $path,
            'title' => $this->photoUpload->getClientOriginalName(),
        ]);
        $this->photoUpload = null;
        session()->flash('media_saved', 'Foto caricata.');
    }

    public function deleteMedia(int $mediaId): void
    {
        $media = Media::find($mediaId);
        if ($media && $media->commemorativeProfile->user_id === Auth::id()) {
            Storage::disk('public')->delete($media->file_path);
            $media->delete();
        }
    }

    public function with(): array
    {
        return [
            'uploadedMedia' => $this->profile ? $this->profile->media()->latest()->get() : collect(),
        ];
    }
}; ?>

<div>
    @if($profile)
        <section class="space-y-6">
            <header>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Contenuti Multimediali
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Carica il tuo video-messaggio e le foto che i visitatori vedranno.
                </p>
            </header>

            @if (session('media_saved'))
                <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ session('media_saved') }}
                </div>
            @endif

            <form wire:submit="saveVideoMessage" class="mt-6 space-y-6 border-b border-gray-200 dark:border-gray-700 pb-6">
                <div>
                    <x-input-label for="videoMessageUpload" value="Carica Video Messaggio (Max 100MB)" />
                    <input wire:model="videoMessageUpload" type="file" id="videoMessageUpload" accept="video/*"
                           class="mt-1 block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-md file:border-0
                              file:text-sm file:font-semibold
                              file:bg-indigo-50 dark:file:bg-indigo-900
                              file:text-indigo-700 dark:file:text-indigo-300
                              hover:file:bg-indigo-100" />
                    <x-input-error :messages="$errors->get('videoMessageUpload')" class="mt-2" />
                </div>
                <div x-data="{ uploading: false, progress: 0 }"
                     x-on:livewire-upload-start="uploading = true"
                     x-on:livewire-upload-finish="uploading = false; progress = 0"
                     x-on:livewire-upload-error="uploading = false"
                     x-on:livewire-upload-progress="progress = $event.detail.progress"
                >
                    <div x-show="uploading" class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                        <div class="bg-indigo-600 h-2.5 rounded-full" :style="{ width: progress + '%' }"></div>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <x-primary-button :disabled="!$videoMessageUpload">Salva Video</x-primary-button>
                </div>
            </form>

            <form wire:submit="savePhoto" class="mt-6 space-y-6">
                <div>
                    <x-input-label for="photoUpload" value="Carica Foto (Max 10MB)" />
                    <input wire:model="photoUpload" type="file" id="photoUpload" accept="image/*"
                           class="mt-1 block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-md file:border-0
                              file:text-sm file:font-semibold
                              file:bg-indigo-50 dark:file:bg-indigo-900
                              file:text-indigo-700 dark:file:text-indigo-300
                              hover:file:bg-indigo-100" />
                    <x-input-error :messages="$errors->get('photoUpload')" class="mt-2" />
                </div>
                <div class="flex items-center gap-4">
                    <x-primary-button :disabled="!$photoUpload">Salva Foto</x-primary-button>
                </div>
            </form>

            <div class="mt-6">
                <h3 class="text-md font-medium text-gray-900 dark:text-gray-100">
                    Media Già Caricati
                </h3>
                <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                    @forelse ($uploadedMedia as $media)
                        <!-- MODIFICA: 'relative' è ora qui.
                         Questo div è sia il target per 'group-hover'
                         sia il genitore per il posizionamento 'absolute' del bottone. -->
                        <div class="group relative">
                            <!-- Immagine o Video -->
                            @if ($media->type == 'photo')
                                <img src="{{ Storage::url($media->file_path) }}" alt="{{ $media->title }}"
                                     class="rounded-lg object-cover h-40 w-full">
                            @elseif ($media->type == 'video_message')
                                <div class="rounded-lg h-40 w-full bg-gray-800 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M4 5h10a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V6a1 1 0 011-1z"></path></svg>
                                </div>
                            @endif

                            <!-- BOTTONE:
                             È posizionato in modo assoluto rispetto a 'div.group.relative'.
                             z-10 lo porta sopra i suoi fratelli (img, div, p).
                             'group-hover:opacity-100' si attiva quando si passa il mouse su 'div.group.relative'. -->
                            <button wire:click="deleteMedia({{ $media->id }})"
                                    wire:confirm="Sei sicuro di voler eliminare questo file?"
                                    class="absolute top-1 right-1 z-10 bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>

                            <!-- TITOLO:
                                 È un fratello degli altri elementi, ma il bottone (con z-10)
                                 si posizionerà visivamente sopra di esso. -->
                            <p class="text-xs text-gray-500 truncate mt-1" title="{{ $media->title }}">
                                {{ $media->title }}
                            </p>
                        </div>
                    @empty
                        <p class="col-span-4 text-sm text-gray-500">Non hai ancora caricato nessun media.</p>
                    @endforelse
                </div>
            </div>
        </section>
    @else
        <section class="space-y-6">
            <header>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Contenuti Multimediali
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Per caricare i media, devi prima <span class="font-bold">salvare le informazioni del tuo profilo</span> nel pannello qui sopra.
                </p>
            </header>
        </section>
    @endif
</div>
