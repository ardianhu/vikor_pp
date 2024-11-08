<?php

namespace App\Livewire;

use App\Models\Pesantren;
use Livewire\Component;
use Livewire\WithPagination;

class PesantrenList extends Component
{
    use WithPagination;

    public $pesantrens, $pesantrenId, $name, $address, $long, $latt, $biaya_bulanan, $akreditasi, $total_students, $other_details;
    public $showAddModal = false;
    public $showEditModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:500',
        'long' => 'nullable|string|max:255',
        'latt' => 'nullable|string|max:255',
        'biaya_bulanan' => 'required|integer',
        'akreditasi' => 'required|string|max:5',
        'total_students' => 'required|integer|min:1',
        'other_details' => 'nullable|string'
    ];

    public function mount()
    {
        // $this->pesantrens = Pesantren::with(['facilities', 'learningMethods', 'extracurriculars'])->paginate(10);
    }

    public function render()
    {
        // return view('livewire.pesantren-list');

        // return view('livewire.pesantren-list', [
        //     'pesantrens' => Pesantren::with(['facilities', 'learningMethods', 'extracurriculars'])->paginate(10),
        // ]);

        $pesantren = Pesantren::with(['facilities', 'extracurriculars'])->paginate(10);
        // dd($pesantren);
        return view('livewire.pesantren-list', compact('pesantren'));
    }

    // to show add modal
    public function toogleAddModal()
    {
        $this->resetFields();
        $this->showAddModal = true;
    }

    // to show edit modal
    public function toogleEditModal($id)
    {
        $pesantren = Pesantren::findOrFail($id);
        $this->pesantrenId = $pesantren->id;
        $this->name = $pesantren->name;
        $this->address = $pesantren->address;
        $this->long = $pesantren->long;
        $this->latt = $pesantren->latt;
        $this->biaya_bulanan = $pesantren->biaya_bulanan;
        $this->akreditasi = $pesantren->akreditasi;
        $this->total_students = $pesantren->total_students;
        $this->other_details = $pesantren->other_details;
        $this->showEditModal = true;
    }

    public function resetFields()
    {
        $this->name = '';
        $this->address = '';
        $this->long = '';
        $this->latt = '';
        $this->biaya_bulanan = '';
        $this->akreditasi = '';
        $this->total_students = '';
        $this->other_details = '';
        $this->pesantrenId = null;
    }

    public function savePesantren()
    {
        $this->validate();

        Pesantren::create([
            'name' => $this->name,
            'address' => $this->address,
            'long' => $this->long,
            'latt' => $this->latt,
            'biaya_bulanan' => $this->biaya_bulanan,
            'akreditasi' => $this->akreditasi,
            'total_students' => $this->total_students,
            'other_details' => $this->other_details
        ]);

        $this->showAddModal = false;
        $this->mount();
        session()->flash('message', 'Pesantren berhasil ditambahkan.');
    }

    public function updatePesantren()
    {
        $this->validate();

        $pesantren = Pesantren::findOrFail($this->pesantrenId);
        $pesantren->update([
            'name' => $this->name,
            'address' => $this->address,
            'long' => $this->long,
            'latt' => $this->latt,
            'biaya_bulanan' => $this->biaya_bulanan,
            'akreditasi' => $this->akreditasi,
            'total_students' => $this->total_students,
            'other_details' => $this->other_details
        ]);

        $this->showEditModal = false;
        $this->mount();
        session()->flash('message', 'Pesantren berhasil diupdate.');
    }

    public function deletePesantren($id)
    {
        $pesantren = Pesantren::findOrFail($id);
        $pesantren->delete();
        $this->mount();
        session()->flash('message', 'Pesantren berhasil dihapus.');
    }

    public function closeModals()
    {
        $this->showAddModal = false;
        $this->showEditModal = false;
    }
}
