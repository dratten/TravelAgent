<div class="container mt-5">
    <h2>Edit Flight Route</h2>

    <form wire:submit.prevent="update" wire:loading.class="opacity-50" wire:loading.attr="disabled">
        <div class="mb-3">
            <label class="form-label">Flight Code</label>
            <input type="text" class="form-control" wire:model="flight.flight_code">
        </div>

        <div class="mb-3">
            <label class="form-label">Depart</label>
            <select class="form-select" wire:model="flight.home_code" id="departSelect">
                <option value="">-- None --</option>
                @foreach($airports as $airport)
                    <option value="{{ $airport->id }}" @if($airport->id == $flight['home_code']) selected @endif>
                    {{ $airport->name }} ({{ $airport->iata_code }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Destination</label>
            <select class="form-select" wire:model="flight.destination_code" id="destinationSelect">
                <option value="">-- None --</option>
                @foreach($airports as $airport)
                    <option value="{{ $airport->id }}" @if($airport->id == $flight['destination_code']) selected @endif>
                    {{ $airport->name }} ({{ $airport->iata_code }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Airline</label>
            <select class="form-select" wire:model="flight.airline_id">
                <option value="">-- Select Airline --</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" @if($company->id == $flight['airline_id']) selected @endif>
                        {{ $company->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Flight</button>
        <a href="{{ route('flight-config') }}" class="btn btn-secondary">Cancel</a>
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
                    <p>Please wait while we update the flight information.</p>
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>