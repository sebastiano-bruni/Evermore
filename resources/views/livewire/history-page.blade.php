<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Cronologia Visite
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <p class="mb-4">Questa mappa mostra le posizioni delle tue visite.</p>

                    <div id="map" style="height: 60vh; width: 100%;" class="rounded-lg"></div>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:navigated', () => {

                // 1. Prende i dati delle visite da Livewire (PHP)
                const visits = @json($visits);
                let map; // Dichiara la mappa

                // 2. Controlla se ci sono visite per decidere dove centrare
                if (visits.length > 0) {
                    // Se ci sono visite, centra sulla prima
                    map = L.map('map').setView([visits[0].lat, visits[0].lng], 13);
                } else {
                    // Se NON ci sono visite, centra la mappa sull'Italia/Marche
                    // Ho messo le coordinate di Tolentino (43.20, 13.28)
                    map = L.map('map').setView([43.209, 13.287], 9);
                }

                // 3. Aggiunge il "tile layer" (le mattonelle della mappa)
                // QUESTA PARTE ORA È FUORI DALL'IF, COSÌ SI CARICA SEMPRE
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                // 4. Aggiunge i "pin" (Markers) solo se ci sono visite
                visits.forEach(visit => {
                    const marker = L.marker([visit.lat, visit.lng]).addTo(map);

                    // Aggiunge il popup con le informazioni della visita
                    marker.bindPopup(
                        `<b>${visit.name}</b><br>Visitato il: ${visit.date}`
                    );
                });

            });
        </script>
    @endpush
</div>
