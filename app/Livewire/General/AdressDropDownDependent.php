<?php

namespace App\Livewire\General;

use App\Services\Dashboard\WorldService;
use Livewire\Component;

class AdressDropDownDependent extends Component
{
    public $countryId, $governorateId, $cityId       ;
     protected WorldService $worldService;

    public function boot(WorldService $worldService)
    {
        $this->worldService = $worldService;
    }

    public function render()
    {

        return view('livewire.general.adress-drop-down-dependent', [
            'countries' => $this->worldService->getAllCountries(),
            'governorates' => $this->countryId
                ? $this->worldService->getAllgovernorates($this->countryId)
                : [],
            'cities' => $this->governorateId
                ? $this->worldService->getAllCities($this->governorateId)
                : [],
        ]);
    }
}
