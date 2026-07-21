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
        Schema::create('snapshot_stats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('followers')->default(0);
            $table->unsignedBigInteger('subscribers')->default(0);
            $table->unsignedBigInteger('total_views')->default(0);
            $table->unsignedInteger('years_creating')->default(0);
            $table->unsignedInteger('videos_published')->default(0);
            $table->unsignedBigInteger('community_members')->default(0);

            // Optional auto-sync: when enabled, live-status:poll's sibling
            // stat-sync job overwrites the relevant field(s) from the
            // matching StreamingCredential's API instead of relying on
            // manual entry.
            $table->boolean('sync_followers_from_twitch')->default(false);
            $table->boolean('sync_subscribers_from_youtube')->default(false);
            $table->boolean('sync_total_views_from_youtube')->default(false);
            $table->boolean('sync_videos_from_youtube')->default(false);
            $table->timestamp('last_synced_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('snapshot_stats');
    }
};
