<?php

namespace App\Http\Livewire\Configs;

use App\Models\Flights;
use App\Models\Companies;
use App\Models\Airports;
use Livewire\Component;

class EditFlight extends Component
{
    public $flight;
    public $loading = false;

    public function mount($id)
    {
        $flight = Flights::findOrFail($id);
        $this->flight = $flight->toArray();

        $this->airports = Airports::all();
        $this->companies = Companies::where('type', 'airline')->get();
    }

    public function update()
    {
         $this->loading = true;

        $this->validate([
            'flight.flight_code' => 'required|string',
            'flight.home_code' => 'nullable|exists:airports,id',
            'flight.destination_code' => 'nullable|exists:airports,id',
            'flight.airline_id' => 'required|exists:companies,id',
        ]);

        $flight = Flights::findOrFail($this->flight['id']);

        $flight->update($this->flight);

        $this->loading = false;

        return redirect()->route('flight-config')->with('success', 'Flight edited successfully.'); // Adjust if your list route is different
    }

    public function render()
    {
        return view('livewire.configs.edit-flight');
    }
}
