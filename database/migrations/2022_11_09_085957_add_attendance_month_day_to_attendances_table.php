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
        Schema::table('attendances', function (Blueprint $table) {
            $table->date('attendance_day')->virtualAs('DATE(check_in)')->after('check_out_location');
            $table->date('attendance_month')->virtualAs('DATE_ADD(check_in, INTERVAL - DAY(check_in)+1 DAY)')->after('attendance_day');
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
            $table->dropColumn('attendance_day');
            $table->dropColumn('attendance_month');
        });
    }
};
