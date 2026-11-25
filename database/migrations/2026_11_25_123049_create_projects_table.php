<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category');
            $table->string('client');
            $table->string('year', 10);
            $table->string('cover');
            $table->text('summary');
            $table->longText('description');
            $table->json('tags')->nullable();
            $table->json('gallery')->nullable();
            $table->boolean('featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
