<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name'); //Client Name
            $table->string('postal_address_1');
            $table->string('postal_address_2')->nullable()->default();
            $table->string('postal_address_3')->nullable()->default();
            $table->string('postal_post_code'); //Postal Code of address
            $table->string('contact_person'); //Contact person for all setup queries
            $table->string('telephone_number'); //Landline
            $table->string('cell_number'); //Cell Number
            $table->string('fax_number'); //Fax Number
            $table->string('email'); //For Customer level detail queries
            $table->string('logo')->nullable()->default(NULL); //For Customer level detail queries
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('companies');
    }

}
