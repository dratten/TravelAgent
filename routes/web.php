<?php

use App\Http\Livewire\Configs\Hotel;
use App\Http\Livewire\Configs\EditHotel;
use App\Http\Livewire\Configs\Flight;
use App\Http\Livewire\Configs\EditFlight;
use App\Http\Livewire\Configs\Car;
use App\Http\Livewire\Configs\EditCar;
use App\Http\Livewire\Configs\Activity;
use App\Http\Livewire\Configs\EditActivity;
use App\Http\Livewire\Operations\Booking;
use App\Http\Livewire\Operations\CreateBooking;
use App\Http\Livewire\BootstrapTables;
use App\Http\Livewire\Components\Buttons;
use App\Http\Livewire\Components\Forms;
use App\Http\Livewire\Components\Modals;
use App\Http\Livewire\Components\Notifications;
use App\Http\Livewire\Components\Typography;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Err404;
use App\Http\Livewire\Err500;
use App\Http\Livewire\ResetPassword;
use App\Http\Livewire\ForgotPassword;
use App\Http\Livewire\Lock;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Profile;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\ForgotPasswordExample;
use App\Http\Livewire\Index;
use App\Http\Livewire\LoginExample;
use App\Http\Livewire\ProfileExample;
use App\Http\Livewire\RegisterExample;
use App\Http\Livewire\Transactions;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\ResetPasswordExample;
use App\Http\Livewire\UpgradeToPro;
use App\Http\Livewire\Users;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/login');

Route::get('/register', Register::class)->name('register');

Route::get('/login', Login::class)->name('login');

Route::get('/forgot-password', ForgotPassword::class)->name('forgot-password');

Route::get('/reset-password/{id}', ResetPassword::class)->name('reset-password')->middleware('signed');

Route::get('/404', Err404::class)->name('404');
Route::get('/500', Err500::class)->name('500');
Route::get('/upgrade-to-pro', UpgradeToPro::class)->name('upgrade-to-pro');

Route::middleware('auth')->group(function () {
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/profile-example', ProfileExample::class)->name('profile-example');
    Route::get('/users', Users::class)->name('users');
    Route::get('/login-example', LoginExample::class)->name('login-example');
    Route::get('/register-example', RegisterExample::class)->name('register-example');
    Route::get('/forgot-password-example', ForgotPasswordExample::class)->name('forgot-password-example');
    Route::get('/reset-password-example', ResetPasswordExample::class)->name('reset-password-example');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/transactions', Transactions::class)->name('transactions');
    Route::get('/bootstrap-tables', BootstrapTables::class)->name('bootstrap-tables');
    Route::get('/lock', Lock::class)->name('lock');
    Route::get('/buttons', Buttons::class)->name('buttons');
    Route::get('/notifications', Notifications::class)->name('notifications');
    Route::get('/forms', Forms::class)->name('forms');
    Route::get('/modals', Modals::class)->name('modals');
    Route::get('/typography', Typography::class)->name('typography');

    //hotels
    Route::get('/hotel-config', Hotel::class)->name('hotel-config');
    Route::post('/hotel-config', [Hotel::class, 'store'])->name('hotel.store');
    Route::get('/hotel-config/{id}/edit', EditHotel::class)->name('hotel.edit');
    Route::post('/hotel-config/{id}/edit', [EditHotel::class, 'update'])->name('hotel.update');
    Route::get('/hotel-config/{id}/delete', [Hotel::class, 'delete'])->name('hotel.delete');

    //flights
    Route::get('/flight-config', Flight::class)->name('flight-config');
    Route::post('/flight-config', [Flight::class, 'store'])->name('flight.store');
    Route::get('/flight-config/{id}/edit', EditFlight::class)->name('flight.edit');
    Route::post('/flight-config/{id}/edit', [EditFlight::class, 'update'])->name('flight.update');
    Route::get('/flight-config/{id}/delete', [Flight::class, 'delete'])->name('flight.delete');

    //cars
    Route::get('/car-config', Car::class)->name('car-config');
    Route::post('/car-config', [Car::class, 'store'])->name('car.store');
    Route::get('/car-config/{id}/edit', EditCar::class)->name('car.edit');
    Route::post('/car-config/{id}/edit', [EditCar::class, 'update'])->name('car.update');
    Route::get('/car-config/{id}/delete', [Car::class, 'delete'])->name('car.delete');
    Route::get('/api/models/{manufacturer_id}', function ($manufacturer_id) {
    return \App\Models\VehicleModels::where('manufacturer_id', $manufacturer_id)->get();
    });

    //activities
    Route::get('/activity-config', Activity::class)->name('activity-config');
    Route::post('/activity-config', [Activity::class, 'store'])->name('activity.store');
    Route::get('/activity-config/{id}/edit', EditActivity::class)->name('activity.edit');
    Route::post('/activity-config/{id}/edit', [EditActivity::class, 'update'])->name('activity.update');
    Route::get('/activity-config/{id}/delete', [Activity::class, 'delete'])->name('activity.delete');

    //bookings
    Route::get('/bookings', Booking::class)->name('bookings');
    Route::get('/bookings/create', CreateBooking::class)->name('bookings.create');
    Route::post('/bookings/create', [CreateBooking::class,'store'])->name('bookings.store');
});
