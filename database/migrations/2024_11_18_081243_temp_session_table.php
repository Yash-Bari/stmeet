<?php

// database/migrations/xxxx_xx_xx_create_temp_sessions_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('temp_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique();
            $table->boolean('is_available')->default(true);
            $table->json('preferences');
            $table->timestamp('last_active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('temp_sessions');
    }
};