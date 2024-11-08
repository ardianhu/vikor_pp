<?php

namespace App\Livewire;

use App\Models\Pesantren;
use Livewire\Component;

class PesantrenDetail extends Component
{
    public $pesantren;
    public $newFacility, $newFacilityDesc, $newMethod, $newMethodDesc, $newExtracurricular, $newExtracurricularDesc;

    public function mount($id)
    {
        $this->pesantren = Pesantren::with(['facilities', 'extracurriculars'])->findOrFail($id);
    }

    public function addFacility()
    {
        if ($this->newFacility) {
            $this->pesantren->facilities()->create(['name' => $this->newFacility, 'description' => $this->newFacilityDesc]);
            $this->newFacility = ''; // Clear input
            $this->pesantren->refresh();
        }
    }

    public function deleteFacility($facilityId)
    {
        $this->pesantren->facilities()->where('id', $facilityId)->delete();
        $this->pesantren->refresh();
    }

    public function addExtracurricular()
    {
        if ($this->newExtracurricular) {
            $this->pesantren->extracurriculars()->create(['name' => $this->newExtracurricular, 'description' => $this->newExtracurricularDesc]);
            $this->newExtracurricular = ''; // Clear input
            $this->pesantren->refresh();
        }
    }

    public function deleteExtracurricular($extraId)
    {
        $this->pesantren->extracurriculars()->where('id', $extraId)->delete();
        $this->pesantren->refresh();
    }

    public function render()
    {
        return view('livewire.pesantren-detail');
    }
}
