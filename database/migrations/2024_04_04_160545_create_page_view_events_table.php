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
        Schema::create('page_view_events', function (Blueprint $table) {
            $table->id();
            $table->string('page');
            $table->string('referrer')->nullable();
            $table->string('user_agent')->nullable(); // Only added when the user is a bot/crawler
            $table->string('anonymous_id')->nullable(); // Ephemeral Anonymized identifier for the user to track daily unique visits
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_view_events');
    }
};
