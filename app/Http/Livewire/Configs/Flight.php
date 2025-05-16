<?php

namespace App\Http\Livewire\Configs;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

use Livewire\Component;
use App\Models\Flights;
use Illuminate\Http\Request;
use App\Models\Companies;
use App\Models\Airports;

class Flight extends Component
{
    use WithPagination;
    public $perPage = 10;

    // Actual filter variables
    public $flightCode;
    
    public $flightName; 
    public $flight;

    protected $listeners = ['delete'];
    protected $updatesQueryString = ['perPage', 'page'];

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    /*public function index()
    {
        $flights = Flights::with(['airlines', 'country'])->paginate($this->perPage);
        return view('livewire.configs.flight', compact('Flights'));
    }*/

    public function resetFilters()
    {
    
    }

    public function delete($id)
    {
        $this->loading = true;

        $flight = Flights::findOrFail($id);

        $deleted = $flight->delete();

        if ($deleted) {
            $this->loading = false;
            return redirect()->back()->with('success', 'Flight route deleted successfully.');
        } else {
            $this->loading = false;
            return redirect()->back()->with('error', 'Flight route could not be deleted.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'depart' => 'nullable|exists:airports,id',
            'destination' => 'nullable|exists:airports,id',
            'airline_id' => 'nullable|exists:companies,id',
        ]);

        $created = Flights::create([
            'flight_code' => $request->code,
            'home_code' => $request->depart,
            'destination_code' => $request->destination,
            'airline_id' => $request->airline_id
        ]);

        Log::info('I here');

        if ($created) {
            return redirect()->back()->with('success', 'Flight route created successfully.');
        } else {
            return redirect()->back()->with('error', 'Flight route could not be created. Please try again.');
        }
    }

    public function render()
    {
        $airlines = Companies::where('type', 'airline')->get();  // Fetch all airlines
        $airports = Airports::all();  // Fetch all airports
        //$flights = $this->Flights ?? Flights::all();
        $query = Flights::query();

        $flights = $query->with(['homeAirport', 'destinationAirport', 'company'])->paginate($this->perPage);

        return view('livewire.configs.flight', compact('flights', 'airports', 'airlines'));
        //return view('livewire.configs.flight');
    }
}