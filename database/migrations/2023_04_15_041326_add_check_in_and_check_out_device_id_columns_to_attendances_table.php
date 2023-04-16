<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCheckInAndCheckOutDeviceIdColumnsToAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->unsignedBigInteger('check_in_device_id')->after('check_in_location')->nullable();
            $table->unsignedBigInteger('check_out_device_id')->after('check_out_location')->nullable();

            $table->foreign('check_in_device_id')
                ->references('id')
                ->on('clocking_devices')
                ->onDelete('cascade');

            $table->foreign('check_out_device_id')
                ->references('id')
                ->on('clocking_devices')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign(['check_in_device_id']);
            $table->dropForeign(['check_out_device_id']);

            $table->dropColumn('check_in_device_id');
            $table->dropColumn('check_out_device_id');
        });
    }
}
