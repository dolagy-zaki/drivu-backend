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
        // Note: The table name is set to 'user' as seen in your phpMyAdmin.
        Schema::create('user', function (Blueprint $table) {
            $table->string('user_id', 30)->primary(); // Primary Key
            $table->string('name', 100);
            $table->string('email', 255)->unique(); // Unique email for each user
            $table->string('phone', 20);
            $table->timestamps(); // Adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};