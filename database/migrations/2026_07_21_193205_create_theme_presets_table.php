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
        Schema::create('theme_presets', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            // Mirrors theme_settings' token columns exactly — a preset is a
            // named, storable snapshot of that same shape.
            $table->string('primary_color');
            $table->string('secondary_color');
            $table->string('background_color');
            $table->string('surface_color');
            $table->string('card_color');
            $table->string('border_color');
            $table->string('success_color');
            $table->string('warning_color');
            $table->string('error_color');
            $table->string('text_primary_color');
            $table->string('text_secondary_color');
            $table->string('text_muted_color');
            $table->string('font_heading');
            $table->string('font_body');
            $table->unsignedSmallInteger('radius');
            $table->string('shadow_style');
            $table->string('animation_intensity');
            $table->string('section_spacing');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_presets');
    }
};
