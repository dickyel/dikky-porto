<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('greeting')->default("Hey 👋 I'm Dikky");
            $table->string('headline')->default("Designer &\nDeveloper");
            $table->string('hire_label')->default('Hire Me');
            $table->string('hire_url')->default('#contact');
            $table->text('bio')->nullable();
            $table->string('photo')->nullable();
            $table->string('availability')->default('(Available for Work)');
            $table->text('about_dark_1')->nullable();
            $table->text('about_mute_1')->nullable();
            $table->text('about_dark_2')->nullable();
            $table->text('about_mute_2')->nullable();
            $table->string('about_cta_label')->default('See my latest work');
            $table->string('services_heading')->default("The coolest Services\nI provide!");
            $table->text('services_subtext')->nullable();
            $table->string('services_button_label')->default('Hire Me');
            $table->string('showcase_heading')->default("Check out our\nawesome showcase!");
            $table->string('contact_eyebrow')->default('Have a project in mind?');
            $table->string('contact_heading')->default("Let's build something\nworth shipping.");
            $table->string('contact_email')->default('hello@dikky.dev');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_profiles');
    }
};
