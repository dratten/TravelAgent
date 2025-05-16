<title>TravelAgent Dashboard - Booking Management</title>
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
                <li class="breadcrumb-item"><a href="#">Operations</a></li>
                <li class="breadcrumb-item active" aria-current="page">Bookings</li>
            </ol>
        </nav>
        <h2 class="h4">Bookings List</h2>
        <p class="mb-0">Manage your customer travel bookings</p>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="#" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center" data-bs-toggle="modal"
            data-bs-target="#createBookingModal">
            <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
            </svg>
            New Booking
        </a>
    </div>
</div>

<div class="card card-body shadow border-0 table-wrapper table-responsive">
    @if($bookings->count())
        <table class="table user-table table-hover align-items-center">
            <thead>
                <tr>
                    <th class="border-bottom">Booking Number</th>
                    <th class="border-bottom">Customer</th>
                    <th class="border-bottom">Booking Date</th>
                    <th class="border-bottom">Return Flight</th>
                    <th class="border-bottom">Status</th>
                    <th class="border-bottom">Date</th>
                    <th class="border-bottom">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                    <tr>
                        <td>{{ $booking->id }}</td>
                        <td>{{ $booking->customer->first_name }} {{ $booking->customer->last_name }}</td>
                        <td>{{ $booking->booking_date }}</td>
                        <td>{{ $booking->is_return ? 'Yes' : 'No' }}</td>
                        <td>{{ ucfirst($booking->status) }}</td>
                        <td>{{ $booking->created_at }}</td>
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
                                        data-bs-toggle="modal" data-bs-target="#viewBookingModal" data-car='@json($booking)'>
                                        <span class="fas fa-user-shield me-2"></span>
                                        View Details
                                    </a>
                                    <a href="{{ route('booking.edit', $booking->id) }}"
                                        class="btn btn-sm btn-outline-secondary">Edit</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $bookings->links('pagination::bootstrap-5') }}
    @else
        <h2 class="h4 modal-title my-3">No bookings found!</h2>
        <p>List a new booking</p>
    @endif
</div>

<!-- View Booking Modal -->
<div class="modal fade" id="viewBookingModal" tabindex="-1" aria-labelledby="viewBookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Booking Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    onclick="window.location.href='/bookings';" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="text-uppercase">General Info</h6>
                <dl class="row">
                    <dt class="col-sm-3">Customer Name</dt>
                    <dd class="col-sm-9" id="booking-customer"></dd>

                    <dt class="col-sm-3">Booking Date</dt>
                    <dd class="col-sm-9" id="booking-date"></dd>

                    <dt class="col-sm-3">Total Cost</dt>
                    <dd class="col-sm-9" id="booking-cost"></dd>

                    <dt class="col-sm-3">Status</dt>
                    <dd class="col-sm-9" id="booking-status"></dd>
                </dl>

                <hr>

                <!-- Flights -->
                <h6 class="text-uppercase mt-4">Flights</h6>
                <div id="flight-details-container"></div>

                <!-- Cars -->
                <h6 class="text-uppercase mt-4">Car Rentals</h6>
                <div id="car-details-container"></div>

                <!-- Hotels -->
                <h6 class="text-uppercase mt-4">Hotel Bookings</h6>
                <div id="hotel-details-container"></div>

                <!-- Activities -->
                <h6 class="text-uppercase mt-4">Activities</h6>
                <div id="activity-details-container"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="window.location.href='/bookings';">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    function populateBookingModal(booking) {
        // Basic Info
        document.getElementById('booking-customer').textContent = booking.customer?.name || 'N/A';
        document.getElementById('booking-date').textContent = booking.booking_date || 'N/A';
        document.getElementById('booking-cost').textContent = booking.total_cost || 'N/A';
        document.getElementById('booking-status').textContent = booking.status || 'N/A';

        const flightContainer = document.getElementById('flight-details-container');
        const carContainer = document.getElementById('car-details-container');
        const hotelContainer = document.getElementById('hotel-details-container');
        const activityContainer = document.getElementById('activity-details-container');

        flightContainer.innerHTML = '';
        carContainer.innerHTML = '';
        hotelContainer.innerHTML = '';
        activityContainer.innerHTML = '';

        booking.details.forEach(detail => {
            const type = detail.bookable_type.split('\\').pop().toLowerCase(); // 'App\\Models\\Flights' → 'flights'

            if (type === 'flights') {
                flightContainer.innerHTML += `
                    <dl class="row border-bottom py-2">
                        <dt class="col-sm-4">Flight Number</dt>
                        <dd class="col-sm-8">${detail.flight_number || 'N/A'}</dd>
                        <dt class="col-sm-4">Start Date</dt>
                        <dd class="col-sm-8">${detail.start_date || 'N/A'}</dd>
                        <dt class="col-sm-4">End Date</dt>
                        <dd class="col-sm-8">${detail.end_date || 'N/A'}</dd>
                        <dt class="col-sm-4">Seats</dt>
                        <dd class="col-sm-8">${detail.number_of_seats || 0}</dd>
                        <dt class="col-sm-4">Cost</dt>
                        <dd class="col-sm-8">${detail.total_cost || 0}</dd>
                    </dl>
                `;

                // Return flight
                if (detail.is_return && detail.return_flight_detail) {
                    flightContainer.innerHTML += `
                        <dl class="row border-bottom py-2">
                            <dt class="col-sm-4">Return Flight Number</dt>
                            <dd class="col-sm-8">${detail.return_flight_detail.flight_number || 'N/A'}</dd>
                            <dt class="col-sm-4">Return Date</dt>
                            <dd class="col-sm-8">${detail.return_flight_detail.start_date || 'N/A'} to ${detail.return_flight_detail.end_date || 'N/A'}</dd>
                            <dt class="col-sm-4">Seats</dt>
                            <dd class="col-sm-8">${detail.return_flight_detail.number_of_seats || 0}</dd>
                            <dt class="col-sm-4">Cost</dt>
                            <dd class="col-sm-8">${detail.return_flight_detail.total_cost || 0}</dd>
                        </dl>
                    `;
                }

            } else if (type === 'vehicles') {
                carContainer.innerHTML += `
                    <dl class="row border-bottom py-2">
                        <dt class="col-sm-4">Number Plate</dt>
                        <dd class="col-sm-8">${detail.number_plate || 'N/A'}</dd>
                        <dt class="col-sm-4">Rental Period</dt>
                        <dd class="col-sm-8">${detail.start_date} → ${detail.end_date}</dd>
                        <dt class="col-sm-4">Cost</dt>
                        <dd class="col-sm-8">${detail.total_cost || 0}</dd>
                    </dl>
                `;

            } else if (type === 'hotels') {
                hotelContainer.innerHTML += `
                    <dl class="row border-bottom py-2">
                        <dt class="col-sm-4">Rooms</dt>
                        <dd class="col-sm-8">${detail.number_of_rooms || 0}</dd>
                        <dt class="col-sm-4">People</dt>
                        <dd class="col-sm-8">${detail.number_of_people || 0}</dd>
                        <dt class="col-sm-4">Stay</dt>
                        <dd class="col-sm-8">${detail.start_date} to ${detail.end_date}</dd>
                        <dt class="col-sm-4">Reservation No.</dt>
                        <dd class="col-sm-8">${detail.reservation_number || 'N/A'}</dd>
                        <dt class="col-sm-4">Cost</dt>
                        <dd class="col-sm-8">${detail.total_cost || 0}</dd>
                    </dl>
                `;

            } else if (type === 'activities') {
                activityContainer.innerHTML += `
                    <dl class="row border-bottom py-2">
                        <dt class="col-sm-4">Activity Date</dt>
                        <dd class="col-sm-8">${detail.start_date || 'N/A'}</dd>
                        <dt class="col-sm-4">Participants</dt>
                        <dd class="col-sm-8">${detail.number_of_people || 0}</dd>
                        <dt class="col-sm-4">Cost</dt>
                        <dd class="col-sm-8">${detail.total_cost || 0}</dd>
                    </dl>
                `;
            }
        });
    }
</script>