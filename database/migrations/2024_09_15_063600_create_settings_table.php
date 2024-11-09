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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string(column: 'site_name');
            $table->string(column: 'email');
            $table->string(column: 'favicon');
            $table->string(column: 'logo');
            $table->string(column: 'facebook');
            $table->string(column: 'twitter');
            $table->string(column: 'instgram');
            $table->string(column: 'youtube');
            $table->string(column: 'phone');
            $table->string(column: 'country');
            $table->string(column: 'city');
            $table->string(column: 'street');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
