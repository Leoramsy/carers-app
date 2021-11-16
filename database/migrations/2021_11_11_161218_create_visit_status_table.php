<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Visits\Status;

class CreateVisitStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visit_status', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('slug');
            $table->string('colour_code');
            $table->timestamps();
        });

        Status::create(['description' => 'Created', 'slug' => Status::CREATED, 'colour_code' => '#808080']);
        Status::create(['description' => 'Completed', 'slug' => Status::COMPLETED, 'colour_code' => '#008000']);
        Status::create(['description' => 'In Progress', 'slug' => Status::IN_PROGRESS, 'colour_code' => '#0000ff']);
        Status::create(['description' => 'Cancelled', 'slug' => Status::CANCELLED, 'colour_code' => '#d60000']);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visit_status');
    }
}
