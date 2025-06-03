<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ad_networks', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Google Ads, Unity Ads, etc.
            $table->string('provider'); // google, unity, facebook, etc.
            $table->json('credentials'); // API keys, secrets, etc.
            $table->boolean('is_active')->default(false);
            $table->json('settings')->nullable(); // Additional settings
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ad_networks');
    }
};