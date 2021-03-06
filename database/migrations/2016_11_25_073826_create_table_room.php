<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRoom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function ($table) {
            $table->integer('id');
            $table->integer('avail');
            $table->integer('floor');
            $table->integer('type_id')
                  ->on('room_types')
                  ->onDelete('cascade');
            $table->date('created_at');
            $table->date('updated_at');
            $table->unique(['floor', 'id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rooms');
    }
}
