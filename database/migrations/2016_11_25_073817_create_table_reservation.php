<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableReservation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function ($table) {
            $table->increments('id');
            $table->string('in_day', 255);
            $table->string('in_month', 255);
            $table->string('in_year', 255);
            $table->string('out_day', 255);
            $table->string('out_month', 255);
            $table->string('out_year', 255);
            $table->integer('floor');
            $table->integer('room_id')
                ->references('id')
                ->on('rooms')
                ->onDelete('cascade');
            $table->integer('guest_id')
                ->references('id')
                ->on('guests')
                ->onDelete('cascade');
            $table->integer('room_type_id')
                ->references('id')
                ->on('room_type')
                ->onDelete('cascade');
            $table->date('created_at');
            $table->date('updated_at');
            $table->unique(['in_day', 'room_id', 'floor']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('reservations');
    }
}
