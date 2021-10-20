<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarerRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carer_roles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('carer_id')->unsigned()->foreign('carer_id')->references('id')->on('carers')->index();
            $table->bigInteger('role_id')->unsigned()->foreign('role_id')->references('id')->on('roles')->index();
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
        Schema::dropIfExists('carer_roles');
    }
}
