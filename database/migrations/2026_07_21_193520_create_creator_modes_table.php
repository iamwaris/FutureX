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
        Schema::create('creator_modes', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('label');
            $table->text('description')->nullable();
            $table->foreignId('theme_preset_id')->nullable()->constrained()->nullOnDelete();
            // [{key, label, is_enabled, order}] — sections to enable/reorder
            // while this mode is active, applied on top of whatever exists.
            $table->json('section_overrides')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creator_modes');
    }
};
