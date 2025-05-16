<div class="container mt-5">
    <h2>Edit Activity</h2>

    <form wire:submit.prevent="update" wire:loading.class="opacity-50" wire:loading.attr="disabled">
        <div class="mb-3">
            <label class="form-label">Activity Code</label>
            <input type="text" class="form-control" wire:model="activity.activity_code">
        </div>

        <div class="mb-3">
            <label class="form-label">Activity Name</label>
            <input type="text" class="form-control" wire:model="activity.title">
        </div>

        <div class="mb-3">
            <label class="form-label">City</label>
            <input type="text" class="form-control" wire:model="activity.city">
        </div>

        <div class="mb-3">
            <label class="form-label">Country</label>
            <select class="form-select" wire:model="activity.country_id" id="countrySelect">
                <option value="">-- Select Country --</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" @if($country->id == ['activity->country_id']) selected @endif>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Company</label>
            <select class="form-select" wire:model="activity.company_id">
                <option value="">-- Select Company --</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" @if($company->id == $activity['company_id']) selected @endif>
                        {{ $company->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Period</label>
            <input type="number" class="form-control" wire:model="activity.period">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea type="text" class="form-control" wire:model="activity.description" rows="4"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Activity</button>
        <a href="{{ route('activity-config') }}" class="btn btn-secondary">Cancel</a>
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
                    <p>Please wait while we update the activity information.</p>
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>