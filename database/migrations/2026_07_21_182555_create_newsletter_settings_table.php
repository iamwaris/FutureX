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
        Schema::create('newsletter_settings', function (Blueprint $table) {
            $table->id();
            $table->string('provider')->default('none'); // none | beehiiv | mailchimp
            $table->text('api_key')->nullable(); // encrypted cast
            $table->string('list_id')->nullable(); // Beehiiv publication_id or Mailchimp list_id
            $table->boolean('is_enabled')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletter_settings');
    }
};
