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
        $table->integer('negative_mark')->default(0);
    });
}

public function down()
{
    Schema::table('scores', function (Blueprint $table) {
        $table->dropColumn('negative_mark');
    });
}

};
