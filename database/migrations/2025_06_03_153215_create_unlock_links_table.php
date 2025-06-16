<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('unlock_links', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('target_url');
            $table->string('short_code')->unique();
            $table->integer('views')->default(0);
            $table->integer('unlocks')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->json('social_requirements')->nullable(); // Requirements for social media actions
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('unlock_links');
    }
};