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

        if (!Schema::hasColumn('scores', 'event_id')) {
            $table->unsignedBigInteger('event_id')->nullable()->after('id');
        }

        if (!Schema::hasColumn('scores', 'team')) {
            $table->string('team')->nullable()->after('event_id');
        }

        if (!Schema::hasColumn('scores', 'group_id')) {
            $table->integer('group_id')->nullable()->after('team');
        }
    });
}

public function down()
{
    Schema::table('scores', function (Blueprint $table) {
        $table->dropColumn(['event_id', 'team', 'group_id']);
    });
}

};
