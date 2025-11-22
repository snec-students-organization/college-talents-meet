<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fixed_participants', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('team');                    // Thuras | Aqeeda
            $table->integer('chest_no')->unique();    // Must be unique
            $table->string('section')->default('senior'); // junior or senior

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fixed_participants');
    }
};
