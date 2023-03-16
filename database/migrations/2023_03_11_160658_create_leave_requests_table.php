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
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('leave_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('leave_session_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['draft','approved', 'rejected', 'pending', 'cancelled'])->default('draft');
            $table->string('short_description')->nullable();
            $table->text('reason');
            $table->text('documents')->nullable();
            $table->text('notes')->nullable();
            $table->date('from');
            $table->date('to');
            $table->integer('duration');
            $table->datetime('applied_on');
            $table->datetime('approved_on')->nullable();
            $table->datetime('rejected_on')->nullable();
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
        Schema::dropIfExists('leave_requests');
    }
};
