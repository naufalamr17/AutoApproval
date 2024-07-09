<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveRequestsTable extends Migration
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
            $table->string('no');
            $table->string('name');
            $table->string('nik');
            $table->string('region');
            $table->string('position');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('destination_place');
            $table->text('activity_purpose');
            $table->string('status')->default("Waiting Approval");
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
}
