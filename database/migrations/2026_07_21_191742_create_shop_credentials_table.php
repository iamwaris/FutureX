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
        Schema::create('shop_credentials', function (Blueprint $table) {
            $table->id();
            $table->string('platform')->unique(); // shopify | fourthwall | woocommerce | gumroad | spring
            $table->string('store_url')->nullable(); // shop domain / site URL, meaning varies by provider
            $table->text('access_token')->nullable(); // encrypted cast
            $table->text('api_secret')->nullable(); // encrypted cast — e.g. WooCommerce consumer secret
            $table->boolean('is_active')->default(false); // the one live provider
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_credentials');
    }
};
