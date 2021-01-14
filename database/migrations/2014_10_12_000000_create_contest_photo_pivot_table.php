<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestPhotoPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contest_photo', function (Blueprint $table) {
            $table->unsignedBigInteger('contest_id')->index();
            $table->foreign('contest_id')->references('id')->on('contests')->onDelete('cascade');
            $table->unsignedBigInteger('photo_id')->index();
            $table->foreign('photo_id')->references('id')->on('photos');
            $table->primary(['contest_id', 'photo_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contest_photo');
    }
}
