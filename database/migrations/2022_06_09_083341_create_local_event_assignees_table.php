<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalEventAssigneesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('local_event_assignees', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('assignee_id');
            $table->foreign('assignee_id')->references('id')->on('assignees');

            $table->unsignedBigInteger('local_event_id');
            $table->foreign('local_event_id')->references('id')->on('local_events');


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
        Schema::dropIfExists('local_event_assignees');
    }
}
