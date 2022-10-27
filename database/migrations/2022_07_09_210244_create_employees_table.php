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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            $table->string('employee_code')->unique();

            $table->unsignedBigInteger('user_id')->nullable();

            $table->unsignedBigInteger('manager_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('designation_id')->nullable();

            // Personal
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('gender'); // ['male', 'female', 'other']
            $table->date('date_of_birth');
            $table->date('birthday');
            $table->string('blood_group'); // ['A+', 'A−', 'B+', 'B−', 'AB+', 'AB−', 'O+', 'O−']
            $table->string('nationality');
            $table->string('country_of_birth');
            // Family
            $table->string('marital_status'); // ['married', 'unmarried']
            $table->date('marriage_anniversary')->nullable();
            $table->string('spouse_first_name')->nullable();
            $table->string('spouse_middle_name')->nullable();
            $table->string('spouse_last_name')->nullable();
            $table->date('spouse_date_of_birth')->nullable();
            $table->date('spouse_birthday')->nullable();
            $table->integer('number_of_children')->nullable();
            // Education
            $table->string('field_of_study')->nullable();
            $table->string('highest_degree')->nullable();
            // Identity
            $table->string('passport_number')->nullable();
            $table->string('uan')->nullable();
            $table->string('aadhaar_number')->nullable();
            $table->string('pan_number')->nullable();
            $table->string('driving_license_number')->nullable();
            $table->string('voter_id')->nullable();
            // Contact
            $table->string('work_email')->nullable();
            $table->string('work_phone_1')->nullable();
            $table->string('work_phone_2')->nullable();
            $table->string('present_address_line_1')->nullable();
            $table->string('present_address_line_2')->nullable();
            $table->string('present_address_city')->nullable();
            $table->string('present_address_state')->nullable();
            $table->string('present_address_post_code')->nullable();
            $table->string('present_address_country')->nullable();
            // Personal Contact
            $table->string('personal_email')->nullable();
            $table->string('personal_phone')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_relation')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('permanent_address_line_1')->nullable();
            $table->string('permanent_address_line_2')->nullable();
            $table->string('permanent_address_city')->nullable();
            $table->string('permanent_address_state')->nullable();
            $table->string('permanent_address_post_code')->nullable();
            $table->string('permanent_address_country')->nullable();
            // Financial
            $table->string('bank_account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_ifsc_code')->nullable();
            $table->string('bank_micr_code')->nullable();
            $table->string('bank_swift_code')->nullable();
            $table->string('bank_iban_code')->nullable();
            $table->string('bank_address_line_1')->nullable();
            $table->string('bank_address_line_2')->nullable();
            $table->string('bank_address_city')->nullable();
            $table->string('bank_address_state')->nullable();
            $table->string('bank_address_post_code')->nullable();
            $table->string('bank_address_country')->nullable();
            $table->string('bank_phone')->nullable();
            $table->string('bank_email')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('manager_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('designation_id')->references('id')->on('designations')->onDelete('cascade');

            $table->string('full_name')->virtualAs('concat(first_name, \' \', last_name)');
            $table->string('employee_code_with_full_name')->virtualAs('concat(employee_code, \': \', first_name, \' \', last_name)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
