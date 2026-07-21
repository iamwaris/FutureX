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
        Schema::create('community_links', function (Blueprint $table) {
            $table->id();
            $table->string('platform'); // discord | reddit | x | instagram | tiktok | youtube
            $table->string('label');
            $table->string('stat_label'); // e.g. "15,200 members"
            $table->string('url');
            $table->boolean('is_primary')->default(false);
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_links');
    }
};
