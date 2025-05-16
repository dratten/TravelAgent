<?php

namespace App\Http\Livewire\Configs;

use App\Models\Cars;
use App\Models\Companies;
use App\Models\VehicleModels;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class EditCar extends Component
{
    public $car;
    public $loading = false;

    public function mount($id)
    {
        $car = Cars::with(['manufacturer', 'vehiclemodel', 'company'])->findOrFail($id);
        $this->car = $car->toArray();

        Log::info($car);

        $this->vehiclemodels = VehicleModels::all();
        $this->manufacturers = Companies::where('type', 'manufacturer')->get();
        $this->companies = Companies::where('type', 'rental')->get();
    }

    public function update()
    {
         $this->loading = true;

        $this->validate([
            'car.car_code' => 'string|max:255',
            'car.seating_no'=> 'required|string|max:255',
            'car.cc'=> 'required|string|max:255',
            'car.fuel'=> 'required|string|max:255',
            'car.body'=> 'required|string|max:255',
        ]);

        $car = Cars::findOrFail($this->car['id']);

        $car->update($this->car);

        $this->loading = false;

        return redirect()->route('car-config')->with('success', 'Car rental edited successfully.'); // Adjust if your list route is different
    }

    public function render()
    {
        return view('livewire.configs.edit-car');
    }
}
