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
        Schema::create('code_generation_events', function (Blueprint $table) {
            $table->id();
            $table->string('language');
            $table->boolean('hasMenubar');
            $table->boolean('hasLineNumbers');
            $table->boolean('hasMenuButtons');
            $table->boolean('hasMenubarText');
            $table->string('background');
            $table->integer('lines');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('code_generation_events');
    }
};
