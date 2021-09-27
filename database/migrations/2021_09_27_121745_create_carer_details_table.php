<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carer_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carer_id')->constrained();
            $table->foreignId('gender_id')->constrained();
            $table->string('health_care_number')->nullable()->default(NULL);
            $table->string('employee_number')->nullable()->default(NULL);
            $table->string('phone_number');
            $table->string('address_1');
            $table->string('address_2')->nullable()->default(NULL);
            $table->string('address_3')->nullable()->default(NULL);
            $table->string('county')->nullable()->default(NULL);
            $table->string('post_code');
            $table->string('next_of_kin')->nullable()->default(NULL);
            $table->string('next_of_kin_phone')->nullable()->default(NULL);
            $table->string('next_of_kin_relationship')->nullable()->default(NULL);
            $table->date('date_of_birth')->nullable()->default(NULL);
            $table->date('start_date')->nullable()->default(NULL);
            $table->date('end_date')->nullable()->default(NULL);
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
        Schema::dropIfExists('carer_details');
    }
}
