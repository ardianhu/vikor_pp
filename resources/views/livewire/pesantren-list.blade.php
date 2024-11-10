<div>

    <!-- Button to open Add pesantren Modal -->
    <!-- <button wire:click="toggleAddModal" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 mb-4">
        Tambah Pesantren
    </button> -->

    <div class="w-full flex items-center justify-between mb-2">
        <h2 class="text-2xl font-bold mb-4">Daftar Pesantren</h2>
        @if(Auth::user()->is_admin)
        <button wire:click="toogleAddModal" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Tambah Pesantren</button>
        @endif
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-50 uppercase bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Nama
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Alamat
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Akreditasi
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Jumlah Santri
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Biaya Bulanan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Lainnya
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @if ($pesantren->count())
                @foreach ($pesantren as $item)
                <tr class="bg-white border-b">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $item->name }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $item->address }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $item->akreditasi }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $item->total_students }}
                    </td>
                    <td class="px-6 py-4">
                        Rp. {{ number_format($item->biaya_bulanan, 0, ',', '.') }}
                    </td>

                    <td>
                        <div class="mb-2">
                            <strong>Fasilitas:</strong> {{ $item->facilities->isEmpty() ? '-' : $item->facilities->pluck('name')->join(', ') }}
                        </div>
                        <div class="mb-2">
                            <strong>Ekstrakurikuler:</strong> {{ $item->extracurriculars->isEmpty() ? '-' : $item->extracurriculars->pluck('name')->join(', ') }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col items-center justify-center space-y-2">
                            <a href="/pesantren/{{ $item->id }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded-md shadow hover:bg-blue-600 transition duration-200">Detail</a>
                            @if(Auth::user()->is_admin)
                            <a href="#" wire:click="toogleEditModal({{ $item->id }})" class="inline-block bg-yellow-500 text-white px-4 py-2 rounded-md shadow hover:bg-yellow-600 transition duration-200">Ubah</a>

                            <a href="#" class="inline-block bg-red-500 text-white px-4 py-2 rounded-md shadow hover:bg-red-600 transition duration-200" onclick="confirmDelete({{ $item->id }})">Hapus</a>
                            @endif
                        </div>

                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    {{ $pesantren->links() }} <!-- For pagination links -->

    <!-- Add/Edit pesantren Modal -->
    @if ($showAddModal || $showEditModal)
    <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-4xl mx-4">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-semibold text-gray-800">{{ $showAddModal ? 'Tambah Pesantren' : 'Edit Pesantren' }}</h3>
                <button type="button" class="text-gray-500 hover:text-gray-700" wire:click="closeModals">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="{{ $showAddModal ? 'savePesantren' : 'updatePesantren' }}">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" wire:model="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Masukkan nama pesantren" />
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                        <input type="text" wire:model="address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Masukkan alamat pesantren" />
                        @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Akreditasi</label>
                        <select wire:model="akreditasi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Pilih Akreditasi</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                        @error('akreditasi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jumlah Santri</label>
                        <input type="number" wire:model="total_students" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Masukkan total santri" />
                        @error('total_students') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Biaya Bulanan</label>
                        <input type="number" wire:model="biaya_bulanan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Masukkan Biaya Bulanan" />
                        @error('biaya_bulanan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Detail</label>
                        <textarea wire:model="other_details" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Masukkan Detail lainnya"></textarea>
                        @error('other_details') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Latitude</label>
                        <input id="latitude" type="text" wire:model="latt" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Masukkan Latitude" />
                        @error('lat') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Longitude</label>
                        <input id="longitude" type="text" wire:model="long" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Masukkan Longitude" />
                        @error('long') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-2">
                    <button type="button" class="py-2 px-4 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500" wire:click="closeModals">
                        Cancel
                    </button>
                    <button type="submit" class="py-2 px-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ $showAddModal ? 'Add' : 'Update' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(pesantrenId) {
        Swal.fire({
            title: 'Hapus Data?',
            text: 'aksi ini akan menghapus data secara permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Iya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                // Call the Livewire delete method with the ID after confirmation
                @this.call('deletePesantren', pesantrenId);
            }
        });
    }
</script>