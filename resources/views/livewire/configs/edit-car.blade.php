<div class="container mt-5">
    <h2>Edit Car Rental</h2>

    <form wire:submit.prevent="update" wire:loading.class="opacity-50" wire:loading.attr="disabled">
        <div class="mb-3">
            <label class="form-label">Car Code</label>
            <input type="text" class="form-control" wire:model="car.car_code">
        </div>

        <dl class="row">
            <dt class="col-sm-4">Manufacturer</dt>
            <dd class="col-sm-8">{{ $car['manufacturer']['name'] }}</dd>

            <dt class="col-sm-4">Model</dt>
            <dd class="col-sm-8">{{ $car['vehiclemodel']['name'] }}</dd>

            <dt class="col-sm-4">Rental Company</dt>
            <dd class="col-sm-8">{{ $car['company']['name'] }}</dd>
        </dl>

        <div class="mb-3">
            <label for="seating" class="form-label">Seating Capacity</label>
            <select class="form-select" wire:model="car.seating_no" id="seating">
                <option value="">-- Select Seating Capacity --</option>
                @foreach([2, 4, 5, 6, 7, 14, 33] as $seat)
                    <option value="{{ $seat }}" @if($car['seating_no'] == $seat) selected @endif>{{ $seat }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="cc" class="form-label">Engine Capacity</label>
            <select class="form-select" wire:model="car.engine_cc" id="cc">
                <option value="">-- Select Engine Capacity --</option>
                @foreach(['1000cc', '1200cc', '1400cc', '1600cc', '1800cc', '2000cc'] as $cc)
                    <option value="{{ $cc }}">{{ $cc }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="fuel" class="form-label">Fuel Type</label>
            <select class="form-select" wire:model="car.fuel_type" id="fuel">
                <option value="">-- Select Fuel Type --</option>
                @foreach(['Petrol', 'Diesel', 'Hybrid', 'Electric'] as $fuel)
                    <option value="{{ $fuel }}">{{ $fuel }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="body" class="form-label">Body Type</label>
            <select class="form-select" wire:model="car.body_type" id="body">
                <option value="">-- Select Body Type --</option>
                @foreach(['Saloon', 'Hatchback', 'Station Wagon', 'Van'] as $body)
                    <option value="{{ $body }}">{{ $body }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Car</button>
        <a href="{{ route('car-config') }}" class="btn btn-secondary">Cancel</a>
    </form>

    <!-- Loading Modal -->
    <div class="modal" tabindex="-1" wire:loading.flex wire:target="update"
        style="background: rgba(0,0,0,0.5); display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title">Processing...</h5>
                </div>
                <div class="modal-body">
                    <p>Please wait while we update the car information.</p>
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>