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
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('leave_types', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('leave_sessions', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('leave_balances', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('leave_types', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('leave_sessions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('leave_balances', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
