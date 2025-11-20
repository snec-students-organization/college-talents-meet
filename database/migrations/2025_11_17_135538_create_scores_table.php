<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('scores', function (Blueprint $table) {
        $table->id();
        $table->foreignId('participant_id')->constrained()->onDelete('cascade');
        $table->integer('mark')->nullable();
        $table->string('grade')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('scores');
}

};
