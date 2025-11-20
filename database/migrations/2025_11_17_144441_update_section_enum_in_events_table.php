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
    // SQLite doesn't support MODIFY COLUMN directly.
    // So we recreate the column using ALTER TABLE RENAME.
    Schema::table('events', function ($table) {
        $table->dropColumn('section');
    });

    Schema::table('events', function ($table) {
        $table->string('section')->default('junior'); 
        // We will validate manually in controller
    });
}

public function down()
{
    Schema::table('events', function ($table) {
        $table->dropColumn('section');
    });

    Schema::table('events', function ($table) {
        $table->enum('section', ['junior', 'senior']);
    });
}

};
