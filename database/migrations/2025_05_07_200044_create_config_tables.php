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
        //Hotels
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('hotel_code')->unique(); // e.g., HTL001
            $table->string('name');
            $table->string('city');
            $table->foreignId('hotel_main_id')->constrained('companies');
            $table->foreignId('country_id')->constrained('countries'); // foreign key
            $table->text('description')->nullable();
            $table->json('policies')->nullable();
            $table->timestamps();
        });
        //Airline
        Schema::create('airlines', function (Blueprint $table) {
            $table->id();
            $table->string('flight_code')->unique(); // e.g., HTL001
            $table->foreignId('home_code')->constrained('airports');
            $table->foreignId('destination_code')->constrained('airports');
            $table->foreignId('airline_id')->constrained('companies'); // foreign key
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(0);
            $table->timestamps();
        });
        //Cars
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('car_code')->nullable(); // e.g., HTL001
            $table->foreignId('manufacturer_id')->constrained('companies');
            $table->foreignId('model_id')->constrained('vehicle_models');
            $table->foreignId('company_id')->constrained('companies'); // foreign key
            $table->integer('seating_no');
            $table->integer('engine_cc');
            $table->enum('fuel_type', ['petrol', 'diesel', 'hybrid', 'electric']);
            $table->enum('body_type', ['saloon', 'wagon', 'hatchback', 'motorcycle', 'van', 'suv', '4x4']);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(0);
            $table->timestamps();
        });
        //Activities
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('activity_code')->nullable(); // e.g., HTL001
            $table->text('title')->nullable();
            $table->string('city');
            $table->foreignId('company_id')->constrained('companies'); // foreign key
            $table->foreignId('country_id')->constrained('countries');
            $table->integer('period');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(0);
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
        Schema::dropIfExists('hotels');
        Schema::dropIfExists('cars');
        Schema::dropIfExists('activities');
        Schema::dropIfExists('airlines');
    }
};
