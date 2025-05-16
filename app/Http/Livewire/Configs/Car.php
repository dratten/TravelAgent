<?php

namespace App\Http\Livewire\Configs;
use App\Models\VehicleModels;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

use Livewire\Component;
use App\Models\Cars;
use Illuminate\Http\Request;
use App\Models\Companies;
use App\Models\Airports;

class Car extends Component
{
    use WithPagination;
    public $perPage = 10;

    // Actual filter variables
    public $car;

    protected $listeners = ['delete'];
    protected $updatesQueryString = ['perPage', 'page'];

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
    
    }

    public function delete($id)
    {
        $this->loading = true;

        $car = Cars::findOrFail($id);

        $deleted = $car->delete();

        if ($deleted) {
            $this->loading = false;
            return redirect()->back()->with('success', 'Car rental deleted successfully.');
        } else {
            $this->loading = false;
            return redirect()->back()->with('error', 'Car rental could not be deleted.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'string|max:255',
            'manufacturer' => 'nullable|exists:companies,id',
            'car_model' => 'nullable|exists:vehicle_models,id',
            'company' => 'nullable|exists:companies,id',
            'seating'=> 'required|string|max:255',
            'cc'=> 'required|string|max:255',
            'fuel'=> 'required|string|max:255',
            'body'=> 'required|string|max:255',
        ]);

        $created = Cars::create([
            'car_code' => $request->code,
            'manufacturer_id' => $request->manufacturer,
            'model_id' => $request->car_model,
            'company_id' => $request->company,
            'seating_no'=> $request->seating,
            'engine_cc'=> $request->cc,
            'fuel_type'=> $request->fuel,
            'body_type'=> $request->body,
        ]);

        if ($created) {
            return redirect()->back()->with('success', 'Car rental created successfully.');
        } else {
            return redirect()->back()->with('error', 'Car rental could not be created. Please try again.');
        }
    }

    public function render()
    {
        $manufacturers = Companies::where('type', 'manufacturer')->get();  // Fetch all airlines
        $companies = Companies::where('type', 'rental')->get();  // Fetch all airlines
        $carmodels = VehicleModels::all();  // Fetch all airports
        //$cars = $this->Cars ?? Cars::all();
        $query = Cars::query();

        $cars = $query->with(['manufacturer', 'vehiclemodel', 'company'])->paginate($this->perPage);

        return view('livewire.configs.car', compact('cars', 'manufacturers', 'companies','carmodels'));
        //return view('livewire.configs.car');
    }
}