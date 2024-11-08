<div>
    <h1 class="text-3xl font-bold mb-4">{{ $pesantren->name }}</h1>
    <p class="text-gray-700">Address: <span class="font-semibold">{{ $pesantren->address }}</span></p>
    <p class="text-gray-700">Akreditasi: <span class="font-semibold">{{ $pesantren->akreditasi }}</span></p>
    <p class="text-gray-700">Total Students: <span class="font-semibold">{{ $pesantren->total_students }}</span></p>
    <p class="text-gray-700">Biaya Bulanan: <span class="font-semibold">Rp. {{ number_format($pesantren->biaya_bulanan, 0, ',', '.') }}</span></p>
    <p class="text-gray-700">Detail: <span class="font-semibold">{{ $pesantren->other_details }}</span></p>

    <div class="mt-8">
        <h2 class="text-2xl font-bold mt-4">Fasilitas</h2>
        <ul class="list-disc pl-5 mt-2">
            @foreach($pesantren->facilities as $facility)
            <li class="flex justify-between items-center mt-2">
                <div>
                    <span class="font-bold">{{ $facility->name }}: </span>
                    <span class="italic">{{ $facility->description }}</span>
                </div>
                <button wire:click="deleteFacility({{ $facility->id }})" class="text-red-500 hover:text-red-700 ml-2">Hapus</button>
            </li>
            @endforeach
        </ul>
        <div class="mt-4">
            <input type="text" wire:model="newFacility" placeholder="Nama Fasilitas" class="input input-bordered w-full p-2 border border-gray-300 rounded-md focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mb-2" />
            <input type="text" wire:model="newFacilityDesc" placeholder="Deskripsi Fasilitas" class="input input-bordered w-full p-2 border border-gray-300 rounded-md focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
            <button wire:click="addFacility" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Tambah Fasilitas</button>
        </div>

        <h2 class="text-2xl font-bold mt-8">Ekstrakurikuler</h2>
        <ul class="list-disc pl-5 mt-2">
            @foreach($pesantren->extracurriculars as $extra)
            <li class="flex justify-between items-center mt-2">
                <div>
                    <span class="font-bold">{{ $extra->name }}: </span>
                    <span class="italic">{{ $extra->description }}</span>
                </div>
                <button wire:click="deleteExtracurricular({{ $extra->id }})" class="text-red-500 hover:text-red-700 ml-2">Hapus</button>
            </li>
            @endforeach
        </ul>
        <div class="mt-4">
            <input type="text" wire:model="newExtracurricular" placeholder="Nama Ekstrakurikuler" class="input input-bordered w-full p-2 border border-gray-300 rounded-md focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mb-2" />
            <input type="text" wire:model="newExtracurricularDesc" placeholder="Deskripsi Ekstrakurikuler" class="input input-bordered w-full p-2 border border-gray-300 rounded-md focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
            <button wire:click="addExtracurricular" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Add Extracurricular</button>
        </div>
    </div>
</div>