<div>
    <form wire:submit.prevent="submit">
        <div class="mb-3">
            <label>Customer</label>
            <select wire:model="customer_id" class="form-select">
                <option value="">Select customer</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Booking Date</label>
            <input type="date" wire:model="booking_date" class="form-control">
        </div>

        {{-- Select Country (applies to all booking details) --}}
        <div class="mb-3">
            <label for="booking_country" class="form-label">Booking Country</label>
            <select id="booking_country" name="booking_country" class="form-select" required>
                <option value="">Select country</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>
        </div>

        <hr>
        <h5>Booking Details</h5>

        @foreach($details as $index => $detail)
            <div class="card mb-3 p-3">
                <div class="d-flex justify-content-between mb-2">
                    <span>Detail {{ $index + 1 }}</span>
                    <button type="button" wire:click="removeDetail({{ $index }})"
                        class="btn btn-sm btn-danger">Remove</button>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <label>Type</label>
                        <select wire:model="details.{{ $index }}.bookable_type" class="form-select">
                            <option value="">Select</option>
                            <option value="car">Car</option>
                            <option value="hotel">Hotel</option>
                            <option value="airline">Airline</option>
                            <option value="activity">Activity</option>
                        </select>
                    </div>

                    @if($detail['bookable_type'] === 'car')
                        <div class="col-md-3">
                            <label>Manufacturer</label>
                            <select wire:model="details.{{ $index }}.manufacturer_id" class="form-select">
                                <option value="">Select</option>
                                @foreach($this->carManufacturers as $manufacturer)
                                    <option value="{{ $manufacturer['id'] }}">{{ $manufacturer['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Model</label>
                            <select wire:model="details.{{ $index }}.vehicle_model_id" class="form-select">
                                <option value="">Select</option>
                                @foreach($this->getVehicleModels($index) as $model)
                                    <option value="{{ $model['id'] }}">{{ $model['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Company</label>
                            <select wire:model="details.{{ $index }}.company_id" class="form-select">
                                <option value="">Select</option>
                                @foreach($this->getCompanies($index) as $company)
                                    <option value="{{ $company['id'] }}">{{ $company['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 mt-2">
                            <label>Number Plate</label>
                            <input type="text" class="form-control" wire:model="details.{{ $index }}.number_plate_id">
                            </select>
                        </div>
                    @endif

                    {{-- Flight Section --}}
                    @if($detail['bookable_type'] === 'flight')
                        <div class="row">
                            <div class="col-md-3">
                                <label>Departure Airport</label>
                                <select wire:model="details.{{ $index }}.home_airport_id" class="form-select">
                                    <option value="">Select</option>
                                    @foreach($airports as $airport)
                                        <option value="{{ $airport->id }}">{{ $airport->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Destination Airport</label>
                                <select wire:model="details.{{ $index }}.destination_airport_id" class="form-select">
                                    <option value="">Select</option>
                                    @foreach($airports as $airport)
                                        <option value="{{ $airport->id }}">{{ $airport->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Airline</label>
                                <select wire:model="details.{{ $index }}.company_id" class="form-select">
                                    <option value="">Select</option>
                                    @foreach($airlines as $airline)
                                        <option value="{{ $airline['company']['id'] }}">{{ $airline['company']['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Flight</label>
                                <select wire:model="details.{{ $index }}.bookable_id" class="form-select">
                                    <option value="">Select</option>
                                    @foreach($this->getFilteredFlights($detail['home_airport_id'], $detail['destination_airport_id'], $detail['company_id']) as $flight)
                                        <option value="{{ $flight['id'] }}">{{ $flight['flight_number'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Return Flight --}}
                        <div class="mt-2">
                            <input type="checkbox" wire:model="details.{{ $index }}.is_return"> Is Return Flight?
                            @if($detail['is_return'])
                                <div class="mt-2">
                                    <label>Select Return Flight</label>
                                    <select wire:model="details.{{ $index }}.return_flight_detail_id" class="form-select">
                                        <option value="">Select return flight</option>
                                        @foreach($this->getReturnFlightOptions($index) as $key => $flight)
                                            <option value="{{ $key }}">Flight {{ $flight['flight_number'] ?? $key }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Hotel Section --}}
                    @if($detail['bookable_type'] === 'hotel')
                        <div class="row">
                            <div class="col-md-6">
                                <label>Country</label>
                                <input type="text" class="form-control country-name"
                                    wire:model="details.{{ $index }}.country_id" readonly>
                            </div>
                            <div class="col-md-6">
                                <label>Hotel</label>
                                <select wire:model="details.{{ $index }}.bookable_id" class="form-select">
                                    <option value="">Select</option>
                                    @foreach($this->getFilteredHotels($detail['country_id']) as $hotel)
                                        <option value="{{ $hotel['id'] }}">{{ $hotel['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                    {{-- Activity Section --}}
                    @if($detail['bookable_type'] === 'activity')
                        <div class="row">
                            <div class="col-md-6">
                                <label>Country</label>
                                <input type="text" class="form-control country-name"
                                    wire:model="details.{{ $index }}.country_id" readonly>
                            </div>
                            <div class="col-md-6">
                                <label>Activity</label>
                                <select wire:model="details.{{ $index }}.bookable_id" class="form-select">
                                    <option value="">Select</option>
                                    @foreach($this->getFilteredActivities($detail['country_id']) as $activity)
                                        <option value="{{ $activity['id'] }}">{{ $activity['title'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                    <div class="col-md-3 mt-2">
                        <label>Start Date</label>
                        <input type="date" wire:model="details.{{ $index }}.start_date" class="form-control">
                    </div>

                    <div class="col-md-3 mt-2">
                        <label>End Date</label>
                        <input type="date" wire:model="details.{{ $index }}.end_date" class="form-control">
                    </div>

                    <div class="col-md-3 mt-2">
                        <label>Unit Cost</label>
                        <input type="number" wire:model="details.{{ $index }}.unit_cost" class="form-control" step="0.01">
                    </div>

                    <div class="col-md-3 mt-2">
                        <label>Total Cost</label>
                        <input type="number" wire:model="details.{{ $index }}.total_cost" class="form-control" step="0.01">
                    </div>
                </div>
            </div>
        @endforeach

        <button type="button" class="btn btn-outline-primary mb-3" wire:click="addDetail">+ Add Detail</button>

        <div class="mb-3">
            <label>Total Booking Cost</label>
            <input type="number" wire:model="total_cost" class="form-control" step="0.01">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select wire:model="status" class="form-select">
                <option value="Pending">Pending</option>
                <option value="Paid">Paid</option>
                <option value="Complete">Complete</option>
                <option value="Cancelled">Cancelled</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create Booking</button>
    </form>
</div>


{{-- Booking Detail Template (hidden) --}}
<template id="booking-detail-template">
    <div class="card mb-3 booking-detail-item border-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Booking Detail</h5>
            <button type="button" class="btn btn-sm btn-danger btn-remove-detail">&times;</button>
        </div>
        <div class="card-body">
            <div class="row g-3">

                {{-- Bookable Type --}}
                <div class="col-md-3">
                    <label>Bookable Type</label>
                    <select name="details[][bookable_type]" class="form-select bookable-type" required>
                        <option value="">Select type</option>
                        <option value="car">Car</option>
                        <option value="hotel">Hotel</option>
                        <option value="airline">Airline</option>
                        <option value="activity">Activity</option>
                    </select>
                </div>

                {{-- Bookable ID --}}
                <div class="col-md-3">
                    <label>Bookable Item</label>
                    <select name="details[][bookable_id]" class="form-select bookable-id" required disabled>
                        <option value="">Select item</option>
                    </select>
                </div>

                {{-- Start Date --}}
                <div class="col-md-3">
                    <label>Start Date</label>
                    <input type="date" name="details[][start_date]" class="form-control" required>
                </div>

                {{-- End Date --}}
                <div class="col-md-3">
                    <label>End Date</label>
                    <input type="date" name="details[][end_date]" class="form-control" required>
                </div>

                <!--cars-->
                <div class="col-md-3 car-selectors" style="display:none;">
                    <label>Manufacturer</label>
                    <select class="form-select manufacturer-select" required>
                        <option value="">Select Manufacturer</option>
                        <!-- options populated dynamically -->
                    </select>
                </div>

                <div class="col-md-3 car-selectors" style="display:none;">
                    <label>Vehicle Model</label>
                    <select class="form-select vehicle-model-select" required disabled>
                        <option value="">Select Vehicle Model</option>
                    </select>
                </div>

                <div class="col-md-3 car-selectors" style="display:none;">
                    <label>Company</label>
                    <select class="form-select company-select" required disabled>
                        <option value="">Select Company</option>
                    </select>
                </div>

                <div class="col-md-3 car-selectors" style="display:none;">
                    <label>Car (Number Plate)</label>
                    <select name="details[][bookable_id]" class="form-select bookable-id" required disabled>
                        <option value="">Select Car</option>
                    </select>
                </div>

                {{-- Unit Cost --}}
                <div class="col-md-3">
                    <label>Unit Cost</label>
                    <input type="number" name="details[][unit_cost]" class="form-control" min="0" step="0.01" required>
                </div>

                {{-- Total Cost --}}
                <div class="col-md-3">
                    <label>Total Cost</label>
                    <input type="number" name="details[][total_cost]" class="form-control" min="0" step="0.01" required>
                </div>

                {{-- Return Flight Checkbox (only for airline) --}}
                <div class="col-md-3 d-flex align-items-center">
                    <div class="form-check mt-4">
                        <input class="form-check-input is-return-flight" type="checkbox" name="details[][is_return]"
                            value="1" disabled>
                        <label class="form-check-label">Is Return Flight</label>
                    </div>
                </div>

                {{-- Return Flight Detail ID --}}
                <div class="col-md-3 return-flight-wrapper" style="display:none;">
                    <label>Return Flight Detail</label>
                    <select name="details[][return_flight_detail_id]" class="form-select return-flight-detail-id"
                        disabled>
                        <option value="">Select return flight</option>
                    </select>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    const bookables = {
        car: @json($cars),
        hotel: @json($hotels),
        airline: @json($airlines),
        activity: @json($activities)
    };

    const container = document.getElementById('booking-details-container');
    const template = document.getElementById('booking-detail-template');

    // Store all added booking detail cards to populate return flights
    let bookingDetailsCards = [];

    document.getElementById('booking_country').addEventListener('change', (e) => {
        const selectedText = e.target.options[e.target.selectedIndex].text;
        document.querySelectorAll('.country-name').forEach(input => {
            input.value = selectedText;
        });
    });

    document.getElementById('add-detail-btn').addEventListener('click', () => {
        const clone = template.content.cloneNode(true);
        const card = clone.querySelector('.booking-detail-item');

        // Populate the country
        const selectedText = document.getElementById('booking_country').options[document.getElementById('booking_country').selectedIndex].text;
        const countryInput = card.querySelector('.country-name');
        if (countryInput) countryInput.value = selectedText;

        // Append the card
        container.appendChild(clone);

        const bookableTypeSelect = card.querySelector('.bookable-type');
        const bookableIdSelect = card.querySelector('.bookable-id');
        const isReturnCheckbox = card.querySelector('.is-return-flight');
        const returnFlightWrapper = card.querySelector('.return-flight-wrapper');
        const returnFlightSelect = card.querySelector('.return-flight-detail-id');

        // When Bookable Type changes, populate bookable_id dropdown
        bookableTypeSelect.addEventListener('change', (e) => {
            const type = e.target.value;

            // Hide all car selectors initially
            const carSelectors = card.querySelectorAll('.car-selectors');
            carSelectors.forEach(el => {
                el.style.display = 'none';
                const sel = el.querySelector('select');
                if (sel) sel.disabled = true;
            });

            isReturnCheckbox.checked = false;
            isReturnCheckbox.disabled = true;
            returnFlightWrapper.style.display = 'none';
            returnFlightSelect.disabled = true;
            returnFlightSelect.innerHTML = '<option value="">Select return flight</option>';

            if (type === 'car') {
                // Show car cascading selects
                carSelectors.forEach(el => {
                    el.style.display = 'block';
                });

                // Populate manufacturer dropdown with unique manufacturers from bookables.car
                const manufacturerSelect = card.querySelector('.manufacturer-select');
                manufacturerSelect.disabled = false;
                manufacturerSelect.innerHTML = '<option value="">Select Manufacturer</option>';

                // Get unique manufacturers from bookables.car
                const uniqueManufacturers = [];
                bookables.car.forEach(car => {
                    const man = car.manufacturer;
                    if (man && !uniqueManufacturers.find(m => m.id === man.id)) {
                        uniqueManufacturers.push(man);
                    }
                });

                uniqueManufacturers.forEach(man => {
                    const option = document.createElement('option');
                    option.value = man.id;
                    option.textContent = man.name;
                    manufacturerSelect.appendChild(option);
                });

                // Clear and disable dependent selects
                const vehicleModelSelect = card.querySelector('.vehicle-model-select');
                const companySelect = card.querySelector('.company-select');
                const bookableIdSelect = card.querySelector('.bookable-id');

                vehicleModelSelect.innerHTML = '<option value="">Select Vehicle Model</option>';
                vehicleModelSelect.disabled = true;

                companySelect.innerHTML = '<option value="">Select Company</option>';
                companySelect.disabled = true;

                bookableIdSelect.innerHTML = '<option value="">Select Car</option>';
                bookableIdSelect.disabled = true;
            } else {
                // Non-car logic - show normal bookable-id dropdown
                bookableIdSelect.innerHTML = '<option value="">Select item</option>';
                bookableIdSelect.disabled = !type || !bookables[type];

                if (type && bookables[type]) {
                    bookables[type].forEach(item => {
                        const opt = document.createElement('option');
                        opt.value = item.id;
                        // Fallback display names, tweak as needed
                        opt.textContent = item.vehiclemodel?.name || item.title || item.number_plate || item.flight_number || 'Item';
                        bookableIdSelect.appendChild(opt);
                    });
                }
            }

            // Enable return flight checkbox only if airline selected
            if (type === 'airline') {
                isReturnCheckbox.disabled = false;
            }
        });

        const manufacturerSelect = card.querySelector('.manufacturer-select');
        const vehicleModelSelect = card.querySelector('.vehicle-model-select');
        const companySelect = card.querySelector('.company-select');
        const bookableIdSelect = card.querySelector('.bookable-id'); // Car select with number_plate

        // When manufacturer changes
        manufacturerSelect.addEventListener('change', () => {
            const manId = manufacturerSelect.value;

            // Filter vehicle models based on selected manufacturer
            const filteredModels = [];
            bookables.car.forEach(car => {
                if (car.manufacturer?.id == manId) {
                    const model = car.vehiclemodel;
                    if (model && !filteredModels.find(m => m.id === model.id)) {
                        filteredModels.push(model);
                    }
                }
            });

            vehicleModelSelect.innerHTML = '<option value="">Select Vehicle Model</option>';
            filteredModels.forEach(model => {
                const option = document.createElement('option');
                option.value = model.id;
                option.textContent = model.name;
                vehicleModelSelect.appendChild(option);
            });
            vehicleModelSelect.disabled = filteredModels.length === 0;

            // Reset downstream selects
            companySelect.innerHTML = '<option value="">Select Company</option>';
            companySelect.disabled = true;

            bookableIdSelect.innerHTML = '<option value="">Select Car</option>';
            bookableIdSelect.disabled = true;
        });

        // When vehicle model changes
        vehicleModelSelect.addEventListener('change', () => {
            const manId = manufacturerSelect.value;
            const modelId = vehicleModelSelect.value;

            // Filter companies based on manufacturer and vehicle model
            const filteredCompanies = [];
            bookables.car.forEach(car => {
                if (car.manufacturer?.id == manId && car.vehiclemodel?.id == modelId) {
                    const comp = car.company;
                    if (comp && !filteredCompanies.find(c => c.id === comp.id)) {
                        filteredCompanies.push(comp);
                    }
                }
            });

            companySelect.innerHTML = '<option value="">Select Company</option>';
            filteredCompanies.forEach(comp => {
                const option = document.createElement('option');
                option.value = comp.id;
                option.textContent = comp.name;
                companySelect.appendChild(option);
            });
            companySelect.disabled = filteredCompanies.length === 0;

            // Reset downstream select
            bookableIdSelect.innerHTML = '<option value="">Select Car</option>';
            bookableIdSelect.disabled = true;
        });

        // When company changes
        companySelect.addEventListener('change', () => {
            const manId = manufacturerSelect.value;
            const modelId = vehicleModelSelect.value;
            const compId = companySelect.value;

            // Filter cars based on manufacturer, vehicle model, company
            const filteredCars = [];
            bookables.car.forEach(car => {
                if (car.manufacturer?.id == manId && car.vehiclemodel?.id == modelId && car.company?.id == compId) {
                    filteredCars.push(car);
                }
            });

            bookableIdSelect.innerHTML = '<option value="">Select Car</option>';
            filteredCars.forEach(car => {
                const option = document.createElement('option');
                option.value = car.id;
                option.textContent = car.number_plate;
                bookableIdSelect.appendChild(option);
            });
            bookableIdSelect.disabled = filteredCars.length === 0;
        });

        // When car (bookable_id) changes - autofill unit cost
        bookableIdSelect.addEventListener('change', () => {
            const carId = bookableIdSelect.value;
            const unitCostInput = card.querySelector('input[name="details[][unit_cost]"]');

            const selectedCar = bookables.car.find(car => car.id == carId);
            if (selectedCar) {
                unitCostInput.value = selectedCar.unit_cost ?? 0;
            } else {
                unitCostInput.value = 0;
            }
        });

        // Toggle return flight select visibility based on checkbox
        isReturnCheckbox.addEventListener('change', (e) => {
            if (e.target.checked) {
                returnFlightWrapper.style.display = 'block';
                returnFlightSelect.disabled = false;

                // Populate return flight options from existing airline booking details that are NOT return flights
                returnFlightSelect.innerHTML = '<option value="">Select return flight</option>';

                bookingDetailsCards.forEach((detailCard, index) => {
                    const typeSelect = detailCard.querySelector('.bookable-type');
                    const isReturn = detailCard.querySelector('.is-return-flight').checked;
                    if (typeSelect.value === 'airline' && !isReturn) {
                        // The card itself is also selectable as a return flight
                        const option = document.createElement('option');
                        option.value = index; // index reference
                        option.textContent = `Flight ID: ${detailCard.querySelector('.bookable-id').value || 'N/A'} - Start: ${detailCard.querySelector('input[name="details[][start_date]"]').value}`;
                        returnFlightSelect.appendChild(option);
                    }
                });
            } else {
                returnFlightWrapper.style.display = 'none';
                returnFlightSelect.disabled = true;
                returnFlightSelect.innerHTML = '<option value="">Select return flight</option>';
            }
        });

        // Remove detail card
        card.querySelector('.btn-remove-detail').addEventListener('click', () => {
            card.remove();
            // Remove from bookingDetailsCards list
            bookingDetailsCards = bookingDetailsCards.filter(c => c !== card);
            // Update return flight selects if any
            updateReturnFlightOptions();
        });

        bookingDetailsCards.push(card);
    });

    // Update all return flight selects when a detail card is removed
    function updateReturnFlightOptions() {
        bookingDetailsCards.forEach(card => {
            const isReturnCheckbox = card.querySelector('.is-return-flight');
            const returnFlightWrapper = card.querySelector('.return-flight-wrapper');
            const returnFlightSelect = card.querySelector('.return-flight-detail-id');

            if (isReturnCheckbox.checked) {
                returnFlightSelect.innerHTML = '<option value="">Select return flight</option>';
                bookingDetailsCards.forEach((detailCard, index) => {
                    const typeSelect = detailCard.querySelector('.bookable-type');
                    const isReturn = detailCard.querySelector('.is-return-flight').checked;
                    if (typeSelect.value === 'airline' && !isReturn) {
                        const option = document.createElement('option');
                        option.value = index;
                        option.textContent = `Flight ID: ${detailCard.querySelector('.bookable-id').value || 'N/A'} - Start: ${detailCard.querySelector('input[name="details[][start_date]"]').value}`;
                        returnFlightSelect.appendChild(option);
                    }
                });
            }
        });
    }
</script>