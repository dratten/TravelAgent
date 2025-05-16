<title>TravelAgent Dashboard - Car rental management</title>
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
                <li class="breadcrumb-item active" aria-current="page">Cars</li>
            </ol>
        </nav>
        <h2 class="h4">Car Rental List</h2>
        <p class="mb-0">Your car rental configurations</p>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="#" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center" data-bs-toggle="modal"
            data-bs-target="#createCarModal">
            <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
            </svg>
            New Car
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
            @if($cars->count())
                <table class="table user-table table-hover align-items-center">
                    <thead>
                        <tr>
                            <th class="border-bottom">
                                <div class="form-check dashboard-check">
                                    <input class="form-check-input" type="checkbox" value="" id="carCheckAll">
                                    <label class="form-check-label" for="carCheckAll">Select All
                                    </label>
                                </div>
                            </th>
                            <th class="border-bottom">Car Code</th>
                            <th class="border-bottom">Manufacturer</th>
                            <th class="border-bottom">Model</th>
                            <th class="border-bottom">Rental Company</th>
                            <th class="border-bottom">Body Type</th>
                            <th class="border-bottom">Fuel Type</th>
                            <th class="border-bottom">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cars as $car)
                            <tr>
                                <td>
                                    <div class="form-check dashboard-check">
                                        <input class="form-check-input car-checkbox" type="checkbox" value="{{ $car->id }}"
                                            id="selected_cars" wire:model="selectedCarId">
                                        <label class="form-check-label" for="selected_cars">
                                        </label>
                                    </div>
                                </td>
                                <td><span class="fw-normal">{{ $car->car_code }}</span></td>
                                <td><span class="fw-normal">{{ $car->manufacturer->name ?? 'N/A'}}</span></td>
                                <td><span class="fw-normal">{{ $car->vehiclemodel->name ?? 'N/A' }}</span></td>
                                <td><span class="fw-normal">{{ $car->company->name ?? 'N/A' }}</span></td>
                                <td><span class="fw-normal">{{ $car->body_type}}</span></td>
                                <td><span class="fw-normal">{{ $car->fuel_type}}</span></td>
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
                                            <a class="dropdown-item d-flex align-items-center view-car-btn" href="#"
                                                data-bs-toggle="modal" data-bs-target="#viewCarModal" data-car='@json($car)'>
                                                <span class="fas fa-user-shield me-2"></span>
                                                View Details
                                            </a>
                                            <a class="dropdown-item d-flex align-items-center"
                                                href="{{ route('car.edit', ['id' => $car->id]) }}">
                                                <span class="fas fa-user-edit me-2"></span>
                                                Edit
                                            </a>
                                            <a class="dropdown-item text-danger d-flex align-items-center"
                                                href="{{ route('car.delete', ['id' => $car->id]) }}">
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
                @if ($cars->hasPages())
                    <div class="d-flex justify-content-end align-items-center mt-3 gap-3">
                        <div>
                            {{ $cars->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif
            @else
                <h2 class="h4 modal-title my-3">No car found!</h2>
                <p>Add a new car rental</p>
            @endif
        </div>

        <!-- Create Car Modal -->
        <div class="modal fade" id="createCarModal" tabindex="-1" aria-labelledby="createCarModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form wire:submit prevent="store" action="#" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createCarModalLabel">Create New Car Rental</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="code" class="form-label">Car Code</label>
                                <input type="text" class="form-control" id="code" name="code">
                            </div>
                            <div class="mb-3">
                                <label for="manufacturer" class="form-label">Manufacturer</label>
                                <select class="form-select" name="manufacturer" id="manufacturer">
                                    <option value="">-- Select Manufacturer --</option>
                                    @foreach($manufacturers as $manufacturer)
                                        <option value="{{ $manufacturer->id }}">{{ $manufacturer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="car_model" class="form-label">Model</label>
                                <select class="form-select" name="car_model" id="car_model">
                                    <option value="">-- Select Model --</option>
                                    {{-- Models will be populated dynamically --}}
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="company" class="form-label">Rental Company</label>
                                <select class="form-select" name="company" id="company">
                                    <option value="">-- Select Rental Company --</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="seating" class="form-label">Seating Capacity</label>
                                <select class="form-select" name="seating" id="seating">
                                    <option value="">-- Select Seating Capacity --</option>
                                    <option value="2">2</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="14">14</option>
                                    <option value="33">33</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="cc" class="form-label">Engine Capacity</label>
                                <select class="form-select" name="cc" id="cc">
                                    <option value="">-- Select Engine Capacity --</option>
                                    <option value="1000cc">1000cc</option>
                                    <option value="1200cc">1200cc</option>
                                    <option value="1400cc">1400cc</option>
                                    <option value="1600cc">1600cc</option>
                                    <option value="1800cc">1800cc</option>
                                    <option value="2000cc">2000cc</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="fuel" class="form-label">Fuel Type</label>
                                <select class="form-select" name="fuel" id="fuel">
                                    <option value="">-- Select Fuel Type --</option>
                                    <option value="Petrol">Petrol</option>
                                    <option value="Diesel">Diesel</option>
                                    <option value="Hybrid">Hybrid</option>
                                    <option value="Electric">Electric</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="body" class="form-label">Body Type</label>
                                <select class="form-select" name="body" id="body">
                                    <option value="">-- Select Body Type --</option>
                                    <option value="Saloon">Saloon</option>
                                    <option value="Hatchback">Hatchback</option>
                                    <option value="Station Wagon">Station Wagon</option>
                                    <option value="Van">Van</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Create Car</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>

        <!-- View Car Modal -->
        <div class="modal fade" id="viewCarModal" tabindex="-1" aria-labelledby="viewCarModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Car Rental Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <dl class="row">
                            <dt class="col-sm-4">Car Code</dt>
                            <dd class="col-sm-8" id="car-code"></dd>

                            <dt class="col-sm-4">Manufacturer</dt>
                            <dd class="col-sm-8" id="manufacturer"></dd>

                            <dt class="col-sm-4">Model</dt>
                            <dd class="col-sm-8" id="car-model"></dd>

                            <dt class="col-sm-4">Rental Company</dt>
                            <dd class="col-sm-8" id="company"></dd>

                            <dt class="col-sm-4">Seating Capacity</dt>
                            <dd class="col-sm-8" id="seating"></dd>

                            <dt class="col-sm-4">Engine Capacity</dt>
                            <dd class="col-sm-8" id="cc"></dd>

                            <dt class="col-sm-4">Fuel Type</dt>
                            <dd class="col-sm-8" id="fuel"></dd>

                            <dt class="col-sm-4">Body Type</dt>
                            <dd class="col-sm-8" id="body"></dd>
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
                const buttons = document.querySelectorAll('.view-car-btn');

                buttons.forEach(button => {
                    button.addEventListener('click', function () {
                        const car = JSON.parse(this.getAttribute('data-car'));

                        document.getElementById('car-code').textContent = car.car_code || 'N/A';
                        document.getElementById('manufacturer').textContent = car.manufacturer?.name || 'N/A';
                        document.getElementById('car-model').textContent = car.vehiclemodel?.name || 'N/A';
                        document.getElementById('company').textContent = car.company?.name || 'N/A';
                        document.getElementById('seating').textContent = car.seating_no || 'N/A';
                        document.getElementById('cc').textContent = car.engine_cc || 'N/A';
                        document.getElementById('fuel').textContent = car.fuel_type || 'N/A';
                        document.getElementById('body').textContent = car.body_type || 'N/A';
                    });
                });
            }); 
        </script>

        <script>
            document.getElementById('manufacturer').addEventListener('change', function () {
                const manufacturerId = this.value;
                const carModelSelect = document.getElementById('car_model');
                carModelSelect.innerHTML = '<option value="">-- Select Model --</option>'; // reset

                if (manufacturerId) {
                    fetch(`/api/models/${manufacturerId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(model => {
                                const option = document.createElement('option');
                                option.value = model.id;
                                option.textContent = model.name;
                                carModelSelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching models:', error);
                        });
                }
            });
        </script>

        <script src="/assets/js/demo.js"></script>