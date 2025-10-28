<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Cronologia Visite
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 border border-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8">
                    <h3 class="text-lg font-medium text-white">Le tue conversazioni passate</h3>
                    <p class="mt-1 text-sm text-gray-400">Qui troverai un riepilogo di tutti i dialoghi che hai avuto.</p>

                    <div class="mt-6 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-gray-700">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-white sm:pl-0">Profilo</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Data Visita</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                            <span class="sr-only">Rivedi</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-800">
                                    @forelse ($visits as $visit)
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-white sm:pl-0">{{ $visit->profile_name }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-400">{{ $visit->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                                <a href="#" class="text-yellow-400 hover:text-yellow-300">Riapri<span class="sr-only">, {{ $visit->profile_name }}</span></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-center text-gray-500 sm:pl-0">
                                                Nessuna visita registrata.
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
