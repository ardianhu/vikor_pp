<div>
    <form wire:submit.prevent="calculateVikor" class="bg-white p-8 w-full mx-auto">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6 text-center">Tentukan bobot untuk kriteria pesantren impianmu</h2>

        <div class="mb-5 flex flex-col md:flex-row items-center">
            <img src="{{ asset('images/akreditasi.png') }}" alt="Akreditasi" class="w-52 h-52 mx-auto object-cover">
            <div class="md:flex-1 md:ml-10">
                <label class="block text-gray-600 font-medium mb-2 text-center md:text-left">Akreditasi</label>
                <!-- <input
                    type="range"
                    wire:model="selectedAkreditasi"
                    min="0"
                    max="5"
                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500" />

                <div class="text-gray-700 font-semibold mt-2">
                    Selected Value: <span></span>
                </div> -->
                <!-- Starts component -->
                <div x-data="{ bobot_akreditasi: 1 }" class="w-full">
                    <div> <input type="range" wire:model="selectedBobotAkreditasi" id="bobot_akreditasi" x-model="bobot_akreditasi" min="1" max="5" step="1" class="w-full mt-2 border border-gray-300 appearance-none rounded-full h-8 px-2 outline-none overflow-hidden" style="--thumb-color: #f94121;"> </div>
                    <div class="mt-4 flex items-center gap-x-2 w-full"> <label for="bobot_akreditasi" class="block text-gray-500">Bobot Akreditasi</label> <input type="number" id="inputBobotAkreditasi" x-model="bobot_akreditasi" min="1" max="5" class="border border-gray-300 rounded-lg px-2 py-1 h-10 w-14 text-gray-700 outline-none focus:ring">/<span x-text="bobot_akreditasi == 5 ? 'Sangat Prioritas' : bobot_akreditasi == 4 ? 'Prioritas Tinggi' : bobot_akreditasi == 3 ? 'Prioritas Menengah' : bobot_akreditasi == 2 ? 'Prioritas Rendah' : 'Bukan Prioritas'"></span></div>
                </div> <!-- Ends component -->
            </div>
        </div>

        <div class="mb-5 flex flex-col md:flex-row items-center">
            <img src="{{ asset('images/jumlah_santri.jpg') }}" alt="Jumlah Santri" class="w-52 h-52 mx-auto object-cover">
            <div class="md:flex-1 md:ml-10">
                <label class="block text-gray-600 font-medium mb-2 text-center md:text-left">Jumlah Santri</label>
                <!-- Starts component -->
                <div x-data="{ bobot_jumlah_santri: 1 }" class="w-full">
                    <div> <input type="range" wire:model="selectedBobotJumlahSantri" id="bobot_jumlah_santri" x-model="bobot_jumlah_santri" min="1" max="5" step="1" class="w-full mt-2 border border-gray-300 appearance-none rounded-full h-8 px-2 outline-none overflow-hidden" style="--thumb-color: #f94121;"> </div>
                    <div class="mt-4 flex items-center gap-x-2 w-full"> <label for="bobot_jumlah_santri" class="block text-gray-500">Bobot Jumlah Santri</label> <input type="number" id="inputBobotJumlahSantri" x-model="bobot_jumlah_santri" min="1" max="5" class="border border-gray-300 rounded-lg px-2 py-1 h-10 w-14 text-gray-700 outline-none focus:ring">/<span x-text="bobot_jumlah_santri == 5 ? 'Sangat Prioritas' : bobot_jumlah_santri == 4 ? 'Prioritas Tinggi' : bobot_jumlah_santri == 3 ? 'Prioritas Menengah' : bobot_jumlah_santri == 2 ? 'Prioritas Rendah' : 'Bukan Prioritas'"></span></div>
                </div> <!-- Ends component -->
            </div>
        </div>

        <div class="mb-5 flex flex-col md:flex-row items-center">
            <img src="{{ asset('images/biaya_bulanan.jpeg') }}" alt="Biaya Bulanan" class="w-52 h-52 mx-auto object-cover">
            <div class="md:flex-1 md:ml-10">
                <label class="block text-gray-600 font-medium mb-2 text-center md:text-left">Biaya Bulanan</label>
                <!-- Starts component -->
                <div x-data="{ bobot_biaya_bulanan: 1 }" class="w-full">
                    <div> <input type="range" wire:model="selectedBobotBiayaBulanan" id="bobot_biaya_bulanan" x-model="bobot_biaya_bulanan" min="1" max="5" step="1" class="w-full mt-2 border border-gray-300 appearance-none rounded-full h-8 px-2 outline-none overflow-hidden" style="--thumb-color: #f94121;"> </div>
                    <div class="mt-4 flex items-center gap-x-2 w-full"> <label for="bobot_biaya_bulanan" class="block text-gray-500">Bobot Biaya Bulanan</label> <input type="number" id="inputBobotBiayaBulanan" x-model="bobot_biaya_bulanan" min="1" max="5" class="border border-gray-300 rounded-lg px-2 py-1 h-10 w-14 text-gray-700 outline-none focus:ring">/<span x-text="bobot_biaya_bulanan == 5 ? 'Sangat Prioritas' : bobot_biaya_bulanan == 4 ? 'Prioritas Tinggi' : bobot_biaya_bulanan == 3 ? 'Prioritas Menengah' : bobot_biaya_bulanan == 2 ? 'Prioritas Rendah' : 'Bukan Prioritas'"></span></div>
                </div> <!-- Ends component -->
            </div>
        </div>

        <div class="mb-5 flex flex-col md:flex-row items-center">
            <img src="{{ asset('images/fasilitas.jpg') }}" alt="Fasilits" class="w-52 h-52 mx-auto object-cover">
            <div class="md:flex-1 md:ml-10">
                <label class="block text-gray-600 font-medium mb-2 text-center md:text-left">Fasilitas</label>
                <!-- Starts component -->
                <div x-data="{ bobot_fasilitas: 1 }" class="w-full">
                    <div> <input type="range" wire:model="selectedBobotFasilitas" id="bobot_fasilitas" x-model="bobot_fasilitas" min="1" max="5" step="1" class="w-full mt-2 border border-gray-300 appearance-none rounded-full h-8 px-2 outline-none overflow-hidden" style="--thumb-color: #f94121;"> </div>
                    <div class="mt-4 flex items-center gap-x-2 w-full"> <label for="bobot_fasilitas" class="block text-gray-500">Bobot Fasilitas</label> <input type="number" id="inputBobotFasilitas" x-model="bobot_fasilitas" min="1" max="5" class="border border-gray-300 rounded-lg px-2 py-1 h-10 w-14 text-gray-700 outline-none focus:ring">/<span x-text="bobot_fasilitas == 5 ? 'Sangat Prioritas' : bobot_fasilitas == 4 ? 'Prioritas Tinggi' : bobot_fasilitas == 3 ? 'Prioritas Menengah' : bobot_fasilitas == 2 ? 'Prioritas Rendah' : 'Bukan Prioritas'"></span></div>
                </div> <!-- Ends component -->
            </div>
        </div>

        <div class="mb-5 flex flex-col md:flex-row items-center">
            <img src="{{ asset('images/ekstrakurikuler.jpg') }}" alt="Ekstrakurikuler" class="w-52 h-52 mx-auto object-cover">
            <div class="md:flex-1 md:ml-10">
                <label class="block text-gray-600 font-medium mb-2 text-center md:text-left">Ekstrakurikuler</label>
                <!-- Starts component -->
                <div x-data="{ bobot_ekstrakurikuler: 1 }" class="w-full">
                    <div> <input type="range" wire:model="selectedBobotEkstrakurikuler" id="bobot_ekstrakurikuler" x-model="bobot_ekstrakurikuler" min="1" max="5" step="1" class="w-full mt-2 border border-gray-300 appearance-none rounded-full h-8 px-2 outline-none overflow-hidden" style="--thumb-color: #f94121;"> </div>
                    <div class="mt-4 flex items-center gap-x-2 w-full"> <label for="bobot_ekstrakurikuler" class="block text-gray-500">Bobot Ekstrakurikuler</label> <input type="number" id="inputBobotEkstrakurikuler" x-model="bobot_ekstrakurikuler" min="1" max="5" class="border border-gray-300 rounded-lg px-2 py-1 h-10 w-14 text-gray-700 outline-none focus:ring">/<span x-text="bobot_ekstrakurikuler == 5 ? 'Sangat Prioritas' : bobot_ekstrakurikuler == 4 ? 'Prioritas Tinggi' : bobot_ekstrakurikuler == 3 ? 'Prioritas Menengah' : bobot_ekstrakurikuler == 2 ? 'Prioritas Rendah' : 'Bukan Prioritas'"></span></div>
                </div> <!-- Ends component -->
            </div>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white font-medium py-3 rounded-lg shadow hover:bg-blue-700 transition duration-200">Ajukan Rekomendasi</button>
    </form>
    @if($results)
    <h3 class="text-lg font-semibold mt-8">Alternatif:</h3>
    <table class="table-auto w-full mt-4">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2">No.</th>
                <th class="px-4 py-2">Alternatif</th>
                <th class="px-4 py-2">Akreditasi(C1)</th>
                <th class="px-4 py-2">Jumlah Santri(C2)</th>
                <th class="px-4 py-2">Biaya Bulanan(C3)</th>
                <th class="px-4 py-2">Fasilitas(C4)</th>
                <th class="px-4 py-2">Ekstrakurikuler(C5)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alternativeResults as $index => $result)
            <tr>
                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                <td class="border px-4 py-2">{{ $result['name'] }}</td>
                <td class="border px-4 py-2">{{ $result['akreditasi'] }}</td>
                <td class="border px-4 py-2">{{ $result['jumlah_santri'] }}</td>
                <td class="border px-4 py-2">{{ $result['biaya_bulanan'] }}</td>
                <td class="border px-4 py-2">{{ $result['fasilitas'] }}</td>
                <td class="border px-4 py-2">{{ $result['ekstrakurikuler'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h3 class="text-lg font-semibold mt-8">Normalisasi:</h3>
    <table class="table-auto w-full mt-4">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2">No.</th>
                <th class="px-4 py-2">Alternatif</th>
                <th class="px-4 py-2">Akreditasi</th>
                <th class="px-4 py-2">Jumlah Santri</th>
                <th class="px-4 py-2">Biaya Bulanan</th>
                <th class="px-4 py-2">Fasilitas</th>
                <th class="px-4 py-2">Ekstrakurikuler</th>
            </tr>
        </thead>
        <tbody>
            @foreach($normalizedResults as $index => $normalized)
            <tr>
                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                <td class="border px-4 py-2">{{ $normalized['name'] }}</td>
                <td class="border px-4 py-2">{{ $normalized['akreditasi'] }}</td>
                <td class="border px-4 py-2">{{ $normalized['jumlah_santri'] }}</td>
                <td class="border px-4 py-2">{{ $normalized['biaya_bulanan'] }}</td>
                <td class="border px-4 py-2">{{ $normalized['fasilitas'] }}</td>
                <td class="border px-4 py-2">{{ $normalized['ekstrakurikuler'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h3 class="text-lg font-semibold mt-8">Results:</h3>
    <table class="table-auto w-full mt-4">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2">Rank</th>
                <th class="px-4 py-2">Pesantren Name</th>
                <th class="px-4 py-2">VIKOR (Q)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $index => $result)
            <tr>
                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                <td class="border px-4 py-2">{{ $result['name'] }}</td>
                <td class="border px-4 py-2">{{ number_format($result['Q'], 4) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p class="text-gray-600 mt-4">Belum ada rekomendasi, Pastikan anda menentukan bobot kriteria dan klik tombol Ajukan Rekomendasi.</p>
    @endif
</div>
<script>
</script>