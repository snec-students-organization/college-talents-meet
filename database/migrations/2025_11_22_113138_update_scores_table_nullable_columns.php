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
    Schema::table('scores', function (Blueprint $table) {
        $table->unsignedBigInteger('participant_id')->nullable()->change();
        $table->unsignedBigInteger('group_id')->nullable()->change();
        $table->string('team')->nullable()->change();
    });
}

public function down()
{
    Schema::table('scores', function (Blueprint $table) {
        $table->unsignedBigInteger('participant_id')->nullable(false)->change();
        $table->unsignedBigInteger('group_id')->nullable(false)->change();
        $table->string('team')->nullable(false)->change();
    });
}

};
