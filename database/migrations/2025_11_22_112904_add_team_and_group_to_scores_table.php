<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('scores', function (Blueprint $table) {
            if (!Schema::hasColumn('scores', 'team')) {
                $table->string('team')->nullable()->after('participant_id');
            }
            if (!Schema::hasColumn('scores', 'group_id')) {
                $table->unsignedBigInteger('group_id')->nullable()->after('team');
            }
        });
    }

    public function down(): void
    {
        Schema::table('scores', function (Blueprint $table) {
            if (Schema::hasColumn('scores', 'group_id')) {
                $table->dropColumn('group_id');
            }
            if (Schema::hasColumn('scores', 'team')) {
                $table->dropColumn('team');
            }
        });
    }
};
