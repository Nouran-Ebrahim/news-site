<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string(column: 'phone')->unique();
            $table->string('email')->unique();
            $table->string(column: 'username')->unique()->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(1);
            $table->string(column: 'country')->nullable();
            $table->string(column: 'city')->nullable();
            $table->string(column: 'street')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
