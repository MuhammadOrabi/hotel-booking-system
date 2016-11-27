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
            $table->integer('id')->unique();
            $table->string('name', 255);
            $table->longText('description');
            $table->float('base_price');
            $table->integer('avail');
            $table->integer('max');
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
        Schema::drop('rooms');
    }
}
