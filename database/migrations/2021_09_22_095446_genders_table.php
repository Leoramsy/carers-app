<?php

use App\Models\System\Gender;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genders', function (Blueprint $table) {
            $table->string('description');
            $table->string('slug');
            $table->id();
            $table->timestamps();
        });
        // Create the Genders
        Gender::create(['description' => ucfirst(Gender::MALE), 'slug' => Gender::MALE]);
        Gender::create(['description' => ucfirst(Gender::FEMALE), 'slug' => Gender::FEMALE]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('genders');
    }
}
