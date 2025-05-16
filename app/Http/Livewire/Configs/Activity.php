<?php

namespace App\Http\Livewire\Configs;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

use Livewire\Component;
use App\Models\Activities;
use Illuminate\Http\Request;
use App\Models\Companies;
use App\Models\Countries;

class Activity extends Component
{
    use WithPagination;
    public $perPage = 10;

    // Actual filter variables
    public $activity;

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

        $activity = Activities::findOrFail($id);

        $deleted = $activity->delete();

        if ($deleted) {
            $this->loading = false;
            return redirect()->back()->with('success', 'Activity deleted successfully.');
        } else {
            $this->loading = false;
            return redirect()->back()->with('error', 'Activity could not be deleted.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'string|max:255',
            'name' => 'string|max:255',
            'city' => 'string|max:255',
            'company' => 'nullable|exists:companies,id',
            'country'=> 'nullable|exists:countries,id',
            'period' => 'integer|min:1',
            'description' => 'string|max:1000',
        ]);

        $created = Activities::create([
            'activity_code' => $request->code,
            'title' => $request->name,
            'city' => $request->city,
            'company_id' => $request->company,
            'country_id'=> $request->country,
            'period'=> $request->period,
            'description'=> $request->description,
        ]);

        if ($created) {
            return redirect()->back()->with('success', 'Activity created successfully.');
        } else {
            return redirect()->back()->with('error', 'Activity could not be created. Please try again.');
        }
    }

    public function render()
    {
        $companies = Companies::where('type', 'activities')->get();  // Fetch all airlines
        $countries = Countries::all();  // Fetch all airports
        //$activities = $this->Activities ?? Activities::all();
        $query = Activities::query();

        $activities = $query->with(['country', 'company'])->paginate($this->perPage);

        return view('livewire.configs.activity', compact('activities', 'countries', 'companies'));
        //return view('livewire.configs.activity');
    }
}