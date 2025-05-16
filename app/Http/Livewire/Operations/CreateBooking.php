<?php

namespace App\Http\Livewire\Operations;

use Livewire\Component;
use App\Models\Bookings;
use App\Models\Customers;
use App\Models\Cars;
use App\Models\Hotels;
use App\Models\Flights;
use App\Models\Countries;
use App\Models\Activities;
use App\Models\BookingDetails;
use Illuminate\Support\Facades\DB;

class CreateBooking extends Component
{
    public $customers, $cars, $hotels, $airlines, $activities;

    public $customer_id;
    public $booking_date;
    public $status = 'Pending';
    public $total_cost;

    public $details = [];

    public function mount()
    {
        $this->customers = Customers::all();
        $this->cars = Cars::with(['manufacturer', 'vehiclemodel', 'company'])->get()->toArray();
        $this->hotels = Hotels::with(['company', 'country'])->get()->toArray();
        $this->airlines = Flights::with(['company', 'destinationAirport', 'homeAirport'])->get()->toArray();
        $this->countries = Countries::all();
        ;
        $this->activities = Activities::with(['company', 'country'])->get()->toArray();
        ;

        $this->booking_date = now()->toDateString();
        $this->addDetail(); // Start with one detail
    }

    public function addDetail()
    {
        $this->details[] = [
            'bookable_type' => '',
            'bookable_id' => '',
            'start_date' => '',
            'end_date' => '',
            'unit_cost' => 0,
            'quantity' => 1,
            'total_cost' => 0,
            'is_return' => false,
            'return_flight_detail_id' => null,

            // For dynamic selects (only for frontend rendering, not stored)
            'manufacturer_id' => null,
            'vehicle_model_id' => null,
            'company_id' => null,
            'number_plate_id' => null,

            'departure_airport_id' => null,
            'destination_airport_id' => null,
            'flight_number' => '',

            'country_id' => null,
            'activity_id' => null,
            'hotel_id' => null,
            'reservation_number' => ''
        ];
    }

    public function removeDetail($index)
    {
        unset($this->details[$index]);
        $this->details = array_values($this->details);
    }

    public function getCarManufacturersProperty()
    {
        return collect($this->cars)->pluck('manufacturer')->unique('id')->values();
    }

    public function getVehicleModels($index)
    {
        $manufacturerId = $this->details[$index]['manufacturer_id'] ?? null;
        return collect($this->cars)
            ->filter(fn($car) => ($car['manufacturer']['id'] ?? null) == $manufacturerId)
            ->pluck('vehiclemodel')
            ->unique('id')
            ->values();
    }

    public function getCompanies($index)
    {
        $manufacturerId = $this->details[$index]['manufacturer_id'] ?? null;
        $vehicleModelId = $this->details[$index]['vehicle_model_id'] ?? null;

        return collect($this->cars)
            ->filter(function ($car) use ($manufacturerId, $vehicleModelId) {
                return ($car['manufacturer']['id'] ?? null) == $manufacturerId &&
                       ($car['vehiclemodel']['id'] ?? null) == $vehicleModelId;
            })
            ->pluck('company')
            ->unique('id')
            ->values();
    }

    public function getFilteredCars($index)
    {
        $manufacturerId = $this->details[$index]['manufacturer_id'] ?? null;
        $vehicleModelId = $this->details[$index]['vehicle_model_id'] ?? null;
        $companyId = $this->details[$index]['company_id'] ?? null;

        return collect($this->cars)
            ->filter(function ($car) use ($manufacturerId, $vehicleModelId, $companyId) {
                return ($car['manufacturer']['id'] ?? null) == $manufacturerId &&
                       ($car['vehiclemodel']['id'] ?? null) == $vehicleModelId &&
                       ($car['company']['id'] ?? null) == $companyId;
            })
            ->values();
    }

    public function getFilteredHotels($countryId)
    {
        return $this->hotels->filter(fn($hotel) =>
            $hotel['country']['id'] == $countryId
        );
    }

    public function getFilteredFlights($countryId)
{
    return collect($this->airlines)->filter(function ($flight) use ($countryId) {
        return ($flight['home_airport']['country_id'] ?? null) == $countryId ||
               ($flight['destination_airport']['country_id'] ?? null) == $countryId;
    });
}

    public function getFilteredActivities($countryId)
    {
        return $this->activities->filter(fn($activity) =>
            $activity['country']['id'] == $countryId
        );
    }

    public function updated($propertyName)
{
    foreach ($this->details as $index => &$detail) {
        // Ensure detail is an array
        if (!is_array($detail)) continue;

        // Default unit and quantity
        $unit = floatval($detail['unit_cost'] ?? 0);
        $quantity = intval($detail['quantity'] ?? 1);

        // Calculate cost
        $detail['total_cost'] = $quantity * $unit;

        // Handle Car logic
        if ($detail['bookable_type'] === 'car') {
            $car = Cars::with(['manufacturer', 'vehiclemodel', 'company'])->find($detail['bookable_id'] ?? null);
            if ($car) {
                $detail['manufacturer_id'] = $car->manufacturer->id ?? null;
                $detail['vehicle_model_id'] = $car->vehiclemodel->id ?? null;
                $detail['company_id'] = $car->company->id ?? null;
            }
        }

        // Handle Flight logic
        if ($detail['bookable_type'] === 'airline') {
            $flight = Flights::with(['company', 'destinationAirport', 'homeAirport'])->find($detail['bookable_id'] ?? null);
            if ($flight) {
                $detail['company_id'] = $flight->company->id ?? null;
                $detail['departure_airport_id'] = $flight->homeAirport->id ?? null;
                $detail['destination_airport_id'] = $flight->destinationAirport->id ?? null;
            }
        }

        // Handle Hotel logic
        if ($detail['bookable_type'] === 'hotel') {
            $hotel = Hotels::with(['company', 'country'])->find($detail['bookable_id'] ?? null);
            if ($hotel) {
                $detail['country_id'] = $hotel->country->id ?? null;
                $detail['company_id'] = $hotel->company->id ?? null;
            }
        }

        // Handle Activity logic
        if ($detail['bookable_type'] === 'activity') {
            $activity = Activities::with(['company', 'country'])->find($detail['bookable_id'] ?? null);
            if ($activity) {
                $detail['country_id'] = $activity->country->id ?? null;
                $detail['company_id'] = $activity->company->id ?? null;
            }
        }
    }

    // Recalculate total booking cost
    $this->total_cost = collect($this->details)->sum('total_cost');
}


    public function store()
    {
        $this->validate([
            'customer_id' => 'required|exists:customers,id',
            'booking_date' => 'required|date',
            'status' => 'required|in:Pending,Paid,Complete,Cancelled',
            'details' => 'required|array|min:1',
            'details.*.bookable_type' => 'required|in:car,hotel,airline,activity',
            'details.*.bookable_id' => 'required|integer',
            'details.*.start_date' => 'required|date',
            'details.*.end_date' => 'required|date|after_or_equal:details.*.start_date',
            'details.*.unit_cost' => 'required|numeric|min:0',
            'details.*.total_cost' => 'required|numeric|min:0',
            'details.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $booking = Bookings::create([
                'customer_id' => $this->customer_id,
                'booking_date' => $this->booking_date,
                'status' => $this->status,
                'total_cost' => $this->total_cost,
            ]);

            $detailRefs = [];

            foreach ($this->details as $index => $detail) {
                $model = 'App\\Models\\' . ucfirst($detail['bookable_type']);

                $bookingDetail = BookingDetails::create([
                    'booking_id' => $booking->id,
                    'bookable_type' => $model,
                    'bookable_id' => $detail['bookable_id'],
                    'start_date' => $detail['start_date'],
                    'end_date' => $detail['end_date'],
                    'unit_cost' => $detail['unit_cost'],
                    'total_cost' => $detail['total_cost'],
                    'is_return' => $detail['is_return'] ?? false,
                ]);

                $detailRefs[$index] = $bookingDetail->id;
            }

            // Assign return flight references
            foreach ($this->details as $index => $detail) {
                if ($detail['is_return'] && $detail['return_flight_detail_id'] !== null) {
                    BookingDetails::where('id', $detailRefs[$index])->update([
                        'return_flight_detail_id' => $detailRefs[$detail['return_flight_detail_id']] ?? null
                    ]);
                }
            }

            DB::commit();
            session()->flash('success', 'Booking created successfully.');
            return redirect()->route('bookings.index');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->addError('error', 'Error: ' . $e->getMessage());
        }
    }
    

    public function render()
    {
        return view('livewire.operations.create-booking');
    }
}
