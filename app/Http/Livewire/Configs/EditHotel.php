<?php

namespace App\Http\Livewire\Configs;

use App\Models\Hotels;
use App\Models\Companies;
use App\Models\Countries;
use Livewire\Component;

class EditHotel extends Component
{
    public $hotel;
    public $loading = false;

    public function mount($id)
    {
        $hotel = Hotels::findOrFail($id);
        $this->hotel = $hotel->toArray();

        $this->countries = Countries::all();
        $this->companies = Companies::where('type', 'hotel')->get();
    }

    public function update()
    {
         $this->loading = true;

        $this->validate([
            'hotel.name' => 'required|string',
            'hotel.city' => 'required|string',
            'hotel.country_id' => 'required|exists:countries,id',
            'hotel.hotel_main_id' => 'required|exists:companies,id',
        ]);

        $hotel = Hotels::findOrFail($this->hotel['id']);

        $hotel->update($this->hotel);

         $this->loading = false;

        return redirect()->route('hotel-config')->with('success', 'Hotel edited successfully.'); // Adjust if your list route is different
    }

    public function render()
    {
        return view('livewire.configs.edit-hotel');
    }
}
