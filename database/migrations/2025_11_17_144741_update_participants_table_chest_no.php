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
    Schema::table('participants', function (Blueprint $table) {
        $table->dropColumn('institution');     // remove institution
        $table->string('chest_no')->nullable()->after('team'); // add chest no
        $table->dropColumn('reg_no');          // remove register number
    });
}

public function down()
{
    Schema::table('participants', function (Blueprint $table) {
        $table->string('institution')->nullable();
        $table->string('reg_no')->nullable();
        $table->dropColumn('chest_no');
    });
}

};
