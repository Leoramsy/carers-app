<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {            
            $table->id();
            $table->foreignId('company_id')->constrained();
            $table->foreignId('gender_id')->constrained(); 
            $table->string('health_care_number')->nullable()->default(NULL);
            $table->string('customer_number')->nullable()->default(NULL); 
            $table->string('name');
            $table->string('surname');
            $table->string('phone')->nullable()->default(NULL);
            $table->string('phone_2')->nullable()->default(NULL);
            $table->string('address_1')->nullable()->default(NULL);
            $table->string('address_2')->nullable()->default(NULL);
            $table->string('city')->nullable()->default(NULL);
            $table->string('county')->nullable()->default(NULL);
            $table->string('postal_code')->nullable()->default(NULL);
            $table->string('email')->nullable()->default(NULL);
            $table->longText('general_notes')->nullable()->default(NULL);
            $table->longText('private_notes')->nullable()->default(NULL);
            $table->longText('accomodation_notes')->nullable()->default(NULL);          
            $table->string('access_to_home')->nullable()->default(NULL);
            $table->string('door_code')->nullable()->default(NULL);
            $table->date('service_start_date')->nullable()->default(NULL);
            $table->date('service_end_date')->nullable()->default(NULL);             
            $table->boolean('active')->default(TRUE);
            $table->integer('created_by')->default(0)->unsigned();
            $table->integer('updated_by')->default(0)->unsigned();
            $table->timestamps();
            
            $table->index('company_id');
            $table->index('gender_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
