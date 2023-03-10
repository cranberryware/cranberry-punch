<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clocking_devices', function (Blueprint $table) {
            $table->id();
            $table->string('device_name');
            $table->string('device_location');
            $table->string('device_serial')->unique();
            $table->string('device_identifier')->unique();
            $table->string('device_status');
            $table->string('device_mode');
            $table->string('emp_prefix')->nullable();
            $table->string('device_secret');
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
        Schema::dropIfExists('clocking_devices');
    }
};
