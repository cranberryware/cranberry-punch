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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('user_id');

            $table->dateTime('check_in');
            $table->dateTime('check_out')->nullable(true);

            $table->double('worked_hours')->virtualAs('TIMESTAMPDIFF(SECOND, check_in, check_out)/3600');

            $table->ipAddress('check_in_ip')->nullable(true);
            $table->string('check_in_location')->nullable(true);
            $table->ipAddress('check_out_ip')->nullable(true);
            $table->string('check_out_location')->nullable(true);

            $table->softDeletes();
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
        Schema::dropIfExists('attendances');
    }
};
