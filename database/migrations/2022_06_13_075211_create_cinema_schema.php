<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    /** ToDo: Create a migration that creates all tables for the following user stories

    For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
    To not introduce additional complexity, please consider only one cinema.

    Please list the tables that you would create including keys, foreign keys and attributes that are required by the user stories.

    ## User Stories

     **Movie exploration**
     * As a user I want to see which films can be watched and at what times
     * As a user I want to only see the shows which are not booked out

     **Show administration**
     * As a cinema owner I want to run different films at different times
     * As a cinema owner I want to run multiple films at the same time in different showrooms

     **Pricing**
     * As a cinema owner I want to get paid differently per show
     * As a cinema owner I want to give different seat types a percentage premium, for example 50 % more for vip seat

     **Seating**
     * As a user I want to book a seat
     * As a user I want to book a vip seat/couple seat/super vip/whatever
     * As a user I want to see which seats are still available
     * As a user I want to know where I'm sitting on my ticket
     * As a cinema owner I dont want to configure the seating for every show
     */
    public function up()
    {
        //Create movies table
        Schema::create('movies', function(Blueprint $table){
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        
        //Create cinemas table
        Schema::create('cinemas', function(Blueprint $table){
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->timestamps();
        });
        
        //Cinema Halls
        Schema::create('cinema_halls', function(Blueprint $table){
            $table->id();
            $table->string('hall_name');
            $table->integer('cinema_id');
            $table->integer('total_seats');
            $table->foreign('cinema_id')->references('id')->on('cinemas')->onDelete('cascade');;
        });
        
        //Hall seat plans
        Schema::create('hall_ticket_seat_pricings', function(Blueprint $table){
            $table->id();
            $table->interger('hall_id');
            $table->integer('seat_type');
            $table->integer('starting_seat_number');
            $table->integer('end_seat_number');
            $table->integer('seat_ticket_price');
            $table->foreign('hall_id')->references('id')->on('cinema_halls')->onDelete('cascade');;
        });
        
        //Shows table
        Schema::create('shows', function(Blueprint $table){
            $table->id();
            $table->integer('movie_id');
            $table->integer('cinema_id');
            $table->integer('hall_id');
            $table->date('show_date');
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->foreign('movie_id')->references('id')->on('moviess')->onDelete('cascade');
            $table->foreign('cinema_id')->references('id')->on('cinemas')->onDelete('cascade');
            $table->foreign('hall_id')->references('id')->on('cinema_halls')->onDelete('cascade');
        });

        //Bookings
        Schema::create('bookings', function(Blueprint $table){
            $table->id();
            $table->integer('user_id');
            $table->double('show_id');
            $table->double('seat_number');
            $table->double('price');
            $table->foreign('show_id')->references('id')->on('shows');
            $table->foreign('user_id')->references('id')->on('users');
        });
        throw new \Exception('implement in coding task 4, you can ignore this exception if you are just running the initial migrations.');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
