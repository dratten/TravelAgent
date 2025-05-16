<?php

namespace App\Http\Livewire\Configs;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\Hotels;
use Illuminate\Http\Request;
use App\Models\Companies;
use App\Models\Countries;

class Hotel extends Component
{
    use WithPagination;
    public $perPage = 10;

    // Actual filter variables
    public $hotelCode;
    
    public $hotelName; 
    
    public $city, $country_id, $company_id;
    public $hotel;

    protected $listeners = ['delete'];
    protected $updatesQueryString = ['perPage', 'page'];

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    /*public function index()
    {
        $hotels = Hotels::with(['companies', 'country'])->paginate($this->perPage);
        return view('livewire.configs.hotel', compact('hotels'));
    }*/

    public function resetFilters()
    {
    
    }

    public function delete($id)
    {
        $this->loading = true;

        $hotel = Hotels::findOrFail($id);

        $deleted = $hotel->delete();

        if ($deleted) {
            $this->loading = false;
            return redirect()->back()->with('success', 'Hotel deleted successfully.');
        } else {
            $this->loading = false;
            return redirect()->back()->with('error', 'Hotel could not be deleted.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country_id' => 'nullable|exists:countries,id',
            'company_id' => 'nullable|exists:companies,id',
        ]);

        $created = Hotels::create([
            'name' => $request->name,
            'hotel_code' => $request->code,
            'city' => $request->city,
            'country_id' => $request->country_id,
            'hotel_main_id' => $request->company_id,
        ]);

        if ($created) {
            return redirect()->back()->with('success', 'Hotel created successfully.');
        } else {
            return redirect()->back()->with('error', 'Hotel could not be created. Please try again.');
        }
    }

    public function render()
    {
        $companies = Companies::where('type', 'hotel')->get();  // Fetch all companies
        $countries = Countries::all();  // Fetch all countries
        //$hotels = $this->hotels ?? Hotels::all();
        $query = Hotels::query();

        if ($this->hotelCode) {
            $query->where('hotel_code', 'like', '%' . $this->hotelCode . '%');
        }

        if (!empty($this->hotelName)) {
            $query->where('name', 'like', '%' . $this->hotelName . '%');
        }

        if (!empty($this->city)) {
            $query->where('city', 'like', '%' . $this->city . '%');
        }

        if (!empty($this->country_id)) {
            $query->where('country_id', $this->country_id);
        }

        if (!empty($this->company_id)) {
            $query->where('hotel_main_id', $this->company_id);
        }

        $hotels = $query->with(['country', 'company'])->paginate($this->perPage);

        return view('livewire.configs.hotel', compact('hotels', 'countries', 'companies'));
        //return view('livewire.configs.hotel');
    }
}