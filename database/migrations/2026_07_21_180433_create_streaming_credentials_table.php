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
        Schema::create('streaming_credentials', function (Blueprint $table) {
            $table->id();
            $table->string('platform')->unique(); // twitch | kick | youtube
            $table->string('channel_id')->nullable(); // broadcaster/channel identifier to query
            $table->text('client_id')->nullable();
            $table->text('client_secret')->nullable(); // encrypted cast
            $table->text('cached_access_token')->nullable(); // encrypted cast
            $table->timestamp('cached_access_token_expires_at')->nullable();
            $table->boolean('is_enabled')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('streaming_credentials');
    }
};
