<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('path', 500);
            $table->string('ip', 45)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->string('referer', 500)->nullable();
            $table->timestamp('viewed_at')->useCurrent();
            $table->index('viewed_at');
            $table->index('path');
            $table->index(['ip', 'viewed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
