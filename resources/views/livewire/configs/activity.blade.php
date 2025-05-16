<title>TravelAgent Dashboard - Activity management</title>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="#">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#">Configuration</a></li>
                <li class="breadcrumb-item active" aria-current="page">Activities</li>
            </ol>
        </nav>
        <h2 class="h4">Activities List</h2>
        <p class="mb-0">Your holiday activities configurations</p>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="#" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center" data-bs-toggle="modal"
            data-bs-target="#createActivityModal">
            <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
            </svg>
            New Activity
        </a>
        <div class="btn-group ms-2 ms-lg-3">
            <button type="button" class="btn btn-sm btn-outline-gray-600">Share</button>
            <button type="button" class="btn btn-sm btn-outline-gray-600">Export</button>
        </div>
    </div>
</div>

<div class="table-settings mb-4">
    <div class="row justify-content-between align-items-center">

        <!-- Livewire Filter Section Start -->

        <!-- Livewire Filter Section End -->

        <div class="table-settings mb-4">
            <div class="row align-items-center justify-content-end">
                <div class="col-4 col-md-2 col-xl-2 ps-md-0 text-end">
                    <div class="dropdown d-flex justify-content-end">
                        <button class="btn btn-sm btn-gray-800 d-inline-flex align-items-center" type="button"
                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <span>{{ $perPage }}</span>
                            <svg class="icon icon-xs ms-2" fill="none" stroke="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M5 7l7 7 7-7H5z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="#" wire:click="$set('perPage', 10)">10 per page</a></li>
                            <li><a class="dropdown-item" href="#" wire:click="$set('perPage', 20)">20 per page</a></li>
                            <li><a class="dropdown-item" href="#" wire:click="$set('perPage', 30)">30 per page</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-body shadow border-0 table-wrapper table-responsive">
            <!--Bulk Actions
    <div class="d-flex mb-3">
        <select class="form-select fmxw-200" aria-label="Message select example">
            <option selected>Bulk Action</option>
            <option value="1">Send Email</option>
            <option value="2">Change Group</option>
            <option value="3">Delete User</option>
        </select>
        <button class="btn btn-sm px-3 btn-secondary ms-3">Apply</button>
    </div>-->
            @if($activities->count())
                <table class="table user-table table-hover align-items-center">
                    <thead>
                        <tr>
                            <th class="border-bottom">
                                <div class="form-check dashboard-check">
                                    <input class="form-check-input" type="checkbox" value="" id="activityCheckAll">
                                    <label class="form-check-label" for="activityCheckAll">Select All
                                    </label>
                                </div>
                            </th>
                            <th class="border-bottom">ActivityCode</th>
                            <th class="border-bottom">Name</th>
                            <th class="border-bottom">City</th>
                            <th class="border-bottom">Company</th>
                            <th class="border-bottom">Country</th>
                            <th class="border-bottom">Period (Hrs)</th>
                            <th class="border-bottom">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activities as $activity)
                            <tr>
                                <td>
                                    <div class="form-check dashboard-check">
                                        <input class="form-check-input activity-checkbox" type="checkbox"
                                            value="{{ $activity->id }}" id="selected_activities"
                                            wire:model="selectedActivityId">
                                        <label class="form-check-label" for="selected_activities">
                                        </label>
                                    </div>
                                </td>
                                <td><span class="fw-normal">{{ $activity->activity_code }}</span></td>
                                <td><span class="fw-normal">{{ $activity->title }}</span></td>
                                <td><span class="fw-normal">{{ $activity->city }}</span></td>
                                <td><span class="fw-normal">{{ $activity->company->name ?? 'N/A'}}</span></td>
                                <td><span class="fw-normal">{{ $activity->country->name ?? 'N/A' }}</span></td>
                                <td><span class="fw-normal">{{ $activity->period }}</span></td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z">
                                                </path>
                                            </svg>
                                            <span class="visually-hidden">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                            <a class="dropdown-item d-flex align-items-center view-activity-btn" href="#"
                                                data-bs-toggle="modal" data-bs-target="#viewActivityModal"
                                                data-activity='@json($activity)'>
                                                <span class="fas fa-user-shield me-2"></span>
                                                View Details
                                            </a>
                                            <a class="dropdown-item d-flex align-items-center"
                                                href="{{ route('activity.edit', ['id' => $activity->id]) }}">
                                                <span class="fas fa-user-edit me-2"></span>
                                                Edit
                                            </a>
                                            <a class="dropdown-item text-danger d-flex align-items-center"
                                                href="{{ route('activity.delete', ['id' => $activity->id]) }}">
                                                <span class="fas fa-user-times me-2"></span>
                                                Delete
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($activities->hasPages())
                    <div class="d-flex justify-content-end align-items-center mt-3 gap-3">
                        <div>
                            {{ $activities->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif
            @else
                <h2 class="h4 modal-title my-3">No activities found!</h2>
                <p>Add a new holiday activity</p>
            @endif
        </div>

        <!-- Create Activity Modal -->
        <div class="modal fade" id="createActivityModal" tabindex="-1" aria-labelledby="createActivityModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form wire:submit prevent="store" action="#" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createActivityModalLabel">Create New Holiday Activity</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="code" class="form-label">Activity Code</label>
                                <input type="text" class="form-control" id="code" name="code" required>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control" id="city" name="city" required>
                            </div>

                            <div class="mb-3">
                                <label for="company" class="form-label">Company</label>
                                <select class="form-select" name="company" id="company">
                                    <option value="">-- None --</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="country" class="form-label">Country</label>
                                <select class="form-select" name="country" id="country">
                                    <option value="">-- None --</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="period" class="form-label">Duration</label>
                                <input type="number" class="form-control" id="period" name="period" required min="1">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4"
                                    required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create Activity</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- View Activity Modal -->
        <div class="modal fade" id="viewActivityModal" tabindex="-1" aria-labelledby="viewActivityModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Activity Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <dl class="row">
                            <dt class="col-sm-4">Activity Code</dt>
                            <dd class="col-sm-8" id="activity-code"></dd>

                            <dt class="col-sm-4">Name</dt>
                            <dd class="col-sm-8" id="activity-name"></dd>

                            <dt class="col-sm-4">City</dt>
                            <dd class="col-sm-8" id="activity-city"></dd>

                            <dt class="col-sm-4">Company</dt>
                            <dd class="col-sm-8" id="activity-company"></dd>

                            <dt class="col-sm-4">Country</dt>
                            <dd class="col-sm-8" id="activity-country"></dd>

                            <dt class="col-sm-4">Period</dt>
                            <dd class="col-sm-8" id="activity-period"></dd>

                            <dt class="col-sm-4">Description</dt>
                            <dd class="col-sm-8" id="activity-description"></dd>
                        </dl>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    showAlert('success', 'Success', '{{ session('success') }}');
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    showAlert('error', 'Error', '{{ session('error') }}');
                });
            </script>
        @endif

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const buttons = document.querySelectorAll('.view-activity-btn');

                buttons.forEach(button => {
                    button.addEventListener('click', function () {
                        const activity = JSON.parse(this.getAttribute('data-activity'));
                        
                        document.getElementById('activity-code').textContent = activity.activity_code || 'N/A';
                        document.getElementById('activity-name').textContent = activity.title 'N/A';
                        document.getElementById('activity-city').textContent = activity.city 'N/A';
                        document.getElementById('activity-company').textContent = activity.company?.name || 'N/A';
                        document.getElementById('activity-country').textContent = activity.country?.name || 'N/A';
                        document.getElementById('activity-period').textContent = activity.period || 'N/A';
                        document.getElementById('activity-description').textContent = activity.description || 'There is no description';
                    });
                });
            });
        </script>

        <script src="/assets/js/demo.js"></script>