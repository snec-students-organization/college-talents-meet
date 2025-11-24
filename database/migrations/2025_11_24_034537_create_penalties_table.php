<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('penalties', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('event_id');
        $table->string('team'); // Thuras or Aqeeda
        $table->integer('points'); // negative value like -5, -10
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('penalties');
}

};
