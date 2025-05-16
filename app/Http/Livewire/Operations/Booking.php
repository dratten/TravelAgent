<?php

namespace App\Http\Livewire\Operations;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

use Livewire\Component;
use App\Models\Bookings;
use Illuminate\Http\Request;

class Booking extends Component
{
    use WithPagination;
    public $perPage = 10;

    // Actual filter variables
    public $booking;

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

        $booking = Bookings::findOrFail($id);

        $deleted = $booking->delete();

        if ($deleted) {
            $this->loading = false;
            return redirect()->back()->with('success', 'Booking rental deleted successfully.');
        } else {
            $this->loading = false;
            return redirect()->back()->with('error', 'Booking rental could not be deleted.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'string|max:255',
            'manufacturer' => 'nullable|exists:companies,id',
            'booking_model' => 'nullable|exists:vehicle_models,id',
            'company' => 'nullable|exists:companies,id',
            'seating'=> 'required|string|max:255',
            'cc'=> 'required|string|max:255',
            'fuel'=> 'required|string|max:255',
            'body'=> 'required|string|max:255',
        ]);

        $created = Bookings::create([
            'booking_code' => $request->code,
            'manufacturer_id' => $request->manufacturer,
            'model_id' => $request->booking_model,
            'company_id' => $request->company,
            'seating_no'=> $request->seating,
            'engine_cc'=> $request->cc,
            'fuel_type'=> $request->fuel,
            'body_type'=> $request->body,
        ]);

        if ($created) {
            return redirect()->back()->with('success', 'Booking rental created successfully.');
        } else {
            return redirect()->back()->with('error', 'Booking rental could not be created. Please try again.');
        }
    }

    public function render()
    {

        $bookings = Bookings::with(['customer','details.bookable','details.returnFlightDetail'])->latest()
        ->paginate($this->perPage);

        return view('livewire.operations.booking', compact('bookings'));
        //return view('livewire.configs.booking');
    }
}