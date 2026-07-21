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
        Schema::create('media_kits', function (Blueprint $table) {
            $table->id();
            $table->text('bio')->nullable();
            $table->json('brand_values')->nullable(); // simple string tags
            $table->unsignedBigInteger('avg_viewers')->default(0);
            $table->unsignedBigInteger('peak_viewers')->default(0);
            $table->unsignedBigInteger('monthly_impressions')->default(0);
            $table->json('age_ranges')->nullable(); // [{label, percentage}]
            $table->json('gender_distribution')->nullable(); // [{label, percentage}]
            $table->json('languages')->nullable(); // [{label, percentage}]
            $table->json('geographic_breakdown')->nullable(); // [{label, percentage}]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_kits');
    }
};
