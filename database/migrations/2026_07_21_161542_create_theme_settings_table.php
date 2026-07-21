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
        Schema::create('theme_settings', function (Blueprint $table) {
            $table->id();

            // Color tokens
            $table->string('primary_color')->default('#6366F1');
            $table->string('secondary_color')->default('#22D3EE');
            $table->string('background_color')->default('#0B0B0F');
            $table->string('surface_color')->default('#131316');
            $table->string('card_color')->default('#18181C');
            $table->string('border_color')->default('#27272A');
            $table->string('success_color')->default('#22C55E');
            $table->string('warning_color')->default('#F59E0B');
            $table->string('error_color')->default('#EF4444');
            $table->string('text_primary_color')->default('#FAFAFA');
            $table->string('text_secondary_color')->default('#A1A1AA');
            $table->string('text_muted_color')->default('#71717A');

            // Typography tokens
            $table->string('font_heading')->default('Inter');
            $table->string('font_body')->default('Inter');

            // Shape & elevation tokens
            $table->unsignedSmallInteger('radius')->default(16);
            $table->string('shadow_style')->default('subtle'); // none | subtle | soft

            // Motion & rhythm tokens
            $table->string('animation_intensity')->default('normal'); // none | subtle | normal | expressive
            $table->string('section_spacing')->default('comfortable'); // compact | comfortable | spacious

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_settings');
    }
};
