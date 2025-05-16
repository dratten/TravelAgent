<title>TravelAgent Dashboard - Flight management</title>
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
                <li class="breadcrumb-item active" aria-current="page">Flights</li>
            </ol>
        </nav>
        <h2 class="h4">Flight Route List</h2>
        <p class="mb-0">Your flight route configurations</p>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="#" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center" data-bs-toggle="modal"
            data-bs-target="#createFlightModal">
            <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
            </svg>
            New Flight
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
            @if($flights->count())
                <table class="table user-table table-hover align-items-center">
                    <thead>
                        <tr>
                            <th class="border-bottom">
                                <div class="form-check dashboard-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flightCheckAll">
                                    <label class="form-check-label" for="flightCheckAll">Select All
                                    </label>
                                </div>
                            </th>
                            <th class="border-bottom">Flight Code</th>
                            <th class="border-bottom">Depart Code</th>
                            <th class="border-bottom">Depart</th>
                            <th class="border-bottom">Destination Code</th>
                            <th class="border-bottom">Destination</th>
                            <th class="border-bottom">Airline</th>
                            <th class="border-bottom">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($flights as $flight)
                            <tr>
                                <td>
                                    <div class="form-check dashboard-check">
                                        <input class="form-check-input flight-checkbox" type="checkbox" value="{{ $flight->id }}"
                                            id="selected_flights" wire:model="selectedFlightId">
                                        <label class="form-check-label" for="selected_flights">
                                        </label>
                                    </div>
                                </td>
                                <td><span class="fw-normal">{{ $flight->flight_code }}</span></td>
                                <td><span class="fw-normal">{{ $flight->homeAirport->iata_code }}</span></td>
                                <td><span class="fw-normal">{{ $flight->homeAirport->name ?? 'N/A' }}</span></td>
                                <td><span class="fw-normal">{{ $flight->destinationAirport->iata_code }}</span></td>
                                <td><span class="fw-normal">{{ $flight->destinationAirport->name ?? 'N/A' }}</span></td>
                                <td><span class="fw-normal">{{ $flight->company->name ?? 'N/A' }}</span></td>
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
                                            <a class="dropdown-item d-flex align-items-center view-flight-btn" href="#"
                                                data-bs-toggle="modal" data-bs-target="#viewFlightModal"
                                                data-flight='@json($flight)'>
                                                <span class="fas fa-user-shield me-2"></span>
                                                View Details
                                            </a>
                                            <a class="dropdown-item d-flex align-items-center"
                                                href="{{ route('flight.edit', ['id' => $flight->id]) }}">
                                                <span class="fas fa-user-edit me-2"></span>
                                                Edit
                                            </a>
                                            <a class="dropdown-item text-danger d-flex align-items-center"
                                                href="{{ route('flight.delete', ['id' => $flight->id]) }}">
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
                @if ($flights->hasPages())
                    <div class="d-flex justify-content-end align-items-center mt-3 gap-3">
                        <div>
                            {{ $flights->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif
            @else
                <h2 class="h4 modal-title my-3">No flight routes found!</h2>
                <p>Add a new flight route</p>
            @endif
        </div>

        <!-- Create Flight Modal -->
        <div class="modal fade" id="createFlightModal" tabindex="-1" aria-labelledby="createFlightModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form wire:submit prevent="store" action="#" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createFlightModalLabel">Create New Flight Route</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="code" class="form-label">Flight Code</label>
                                <input type="text" class="form-control" id="code" name="code" required>
                            </div>
                            <div class="mb-3">
                                <label for="depart" class="form-label">Depart</label>
                                <select class="form-select" name="depart" id="depart">
                                    <option value="">-- None --</option>
                                    @foreach($airports as $airport)
                                        <option value="{{ $airport->id }}">{{ $airport->name }} ({{ $airport->iata_code }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="destination" class="form-label">Destination</label>
                                <select class="form-select" name="destination" id="destination">
                                    <option value="">-- None --</option>
                                    @foreach($airports as $airport)
                                        <option value="{{ $airport->id }}">{{ $airport->name }} ({{ $airport->iata_code }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="airline_id" class="form-label">Airline</label>
                                <select class="form-select" name="airline_id" id="airline_id">
                                    <option value="">-- None --</option>
                                    @foreach($airlines as $airline)
                                        <option value="{{ $airline->id }}">{{ $airline->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create Flight</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- View Flight Modal -->
        <div class="modal fade" id="viewFlightModal" tabindex="-1" aria-labelledby="viewFlightModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Flight Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <dl class="row">
                            <dt class="col-sm-4">Flight Code</dt>
                            <dd class="col-sm-8" id="flight-code"></dd>

                            <dt class="col-sm-4">Depart Airport</dt>
                            <dd class="col-sm-8" id="flight-depart"></dd>

                            <dt class="col-sm-4">Destination Airport</dt>
                            <dd class="col-sm-8" id="flight-destination"></dd>

                            <dt class="col-sm-4">Airline</dt>
                            <dd class="col-sm-8" id="flight-airline"></dd>
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
                const buttons = document.querySelectorAll('.view-flight-btn');

                buttons.forEach(button => {
                    button.addEventListener('click', function () {
                        const flight = JSON.parse(this.getAttribute('data-flight'));

                        document.getElementById('flight-code').textContent = flight.flight_code || 'N/A';
                        document.getElementById('flight-depart').textContent = flight.home_airport?.name +"-"+ flight.home_airport?.iata_code || 'N/A';
                        document.getElementById('flight-destination').textContent = flight.destination_airport?.name +"-"+ flight.destination_airport?.iata_code|| 'N/A';
                        document.getElementById('flight-airline').textContent = flight.company?.name || 'N/A';
                    });
                });
            });
        </script>

        <script src="/assets/js/demo.js"></script>