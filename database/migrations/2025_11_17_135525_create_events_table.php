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
    Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->enum('section', ['junior', 'senior']);
        $table->enum('category', ['A', 'B', 'C', 'D']);
        $table->enum('type', ['individual', 'group', 'general']);
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('events');
}

};
