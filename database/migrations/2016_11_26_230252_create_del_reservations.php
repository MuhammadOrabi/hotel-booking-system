<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDelReservations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('del_reservations', function ($table) {
            $table->increments('id');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('floor');
            $table->integer('room_id')
                ->references('id')
                ->on('rooms')
                ->onDelete('cascade');
            $table->integer('guest_id')
                ->references('id')
                ->on('guests')
                ->onDelete('cascade');
            $table->date('created_at');
            $table->date('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('del_reservations');
    }
}
