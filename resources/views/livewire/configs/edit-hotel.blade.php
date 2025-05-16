<div class="container mt-5">
    <h2>Edit Hotel</h2>

    <form wire:submit.prevent="update" wire:loading.class="opacity-50" wire:loading.attr="disabled">
        <div class="mb-3">
            <label class="form-label">Hotel Name</label>
            <input type="text" class="form-control" wire:model="hotel.name">
        </div>

        <div class="mb-3">
            <label class="form-label">City</label>
            <input type="text" class="form-control" wire:model="hotel.city">
        </div>

        <div class="mb-3">
            <label class="form-label">Country</label>
            <select class="form-select" wire:model="hotel.country_id" id="countrySelect">
                <option value="">-- Select Country --</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" @if($country->id == ['hotel->country_id']) selected @endif>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Company</label>
            <select class="form-select" wire:model="hotel.hotel_main_id">
                <option value="">-- Select Company --</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" @if($company->id == $hotel['hotel_main_id']) selected @endif>
                        {{ $company->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Hotel</button>
        <a href="{{ route('hotel-config') }}" class="btn btn-secondary">Cancel</a>
    </form>

    <!-- Loading Modal -->
    <div class="modal" tabindex="-1" wire:loading.flex wire:target="update" style="background: rgba(0,0,0,0.5); display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title">Processing...</h5>
                </div>
                <div class="modal-body">
                    <p>Please wait while we update the hotel information.</p>
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>