<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Auth\Role;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50);
            $table->string('slug', 50);
            $table->timestamps();
        });

        Role::create(['title' => 'Supervisor', 'slug' => Role::SUPERVISOR,]);
        Role::create(['title' => 'Super Admin', 'slug' => Role::SUPER_ADMIN,]);
        Role::create(['title' => 'Carer', 'slug' => Role::CARER,]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
