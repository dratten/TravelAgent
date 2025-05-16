<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('identification_number');
            $table->foreign('identification_number')
                ->references('identification_number')
                ->on('customers')
                ->onDelete('cascade');
            $table->timestamp('booking_date')->useCurrent();
            $table->enum('status', ['Pending', 'Paid', 'Complete', 'Cancelled'])->default('Pending');
            $table->decimal('total_cost', 10, 2);
            $table->timestamps();
        });

        // Booking Details
        Schema::create('booking_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');

            // Polymorphic keys to reference either car, hotel, airline, or activity
            $table->morphs('bookable');

            $table->date('start_date');
            $table->date('end_date');


            // Specific fields
            $table->string('number_plate')->nullable(); // for cars
            $table->integer('number_of_rooms')->nullable(); // for hotels
            $table->integer('number_of_people')->nullable(); // for hotels and activities
            $table->string('reservation_number')->nullable(); // for hotels
            $table->integer('number_of_seats')->nullable(); // for flights
            $table->boolean('is_return')->nullable(); // for flights
            $table->foreignId('return_flight_detail_id')->nullable()->constrained('booking_details');

            $table->string('flight_number')->nullable(); // for flights

            $table->decimal('unit_cost', 10, 2);
            $table->decimal('total_cost', 10, 2);

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings_tables');
    }
};
