<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Homepage') }}
        </h2>
    </x-slot>

    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @auth
                    {{ __("Halo, ") . auth()->user()->name }} Temukan pesantren impianmu
                    @else
                    {{ __("Halo, ") }} Temukan pesantren impianmu
                    @endauth
                    <span>
                        <a href="/rekomendasi" class="ml-4 bg-blue-500 text-white px-4 py-2 rounded-md shadow hover:bg-blue-600 transition duration-200">Di sini</a>
                    </span>
                </div>

            </div>
        </div>
    </div>

    <div class="pt-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold">Pesantren terbaik berdasarkan hasil vikor sebelumnya:</h3>
                    <table class="table-auto w-full mt-4">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2">Rank</th>
                                <th class="px-4 py-2">Nama Pesantren</th>
                                <!-- <th class="px-4 py-2">Rata-rata Skor</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topPesantren as $index => $result)
                            <tr>
                                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                <td class="border px-4 py-2">{{ $result->pesantren->name }}</td>
                                <!-- <td class="border px-4 py-2">{{ $result->avg_score }}</td> -->
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>