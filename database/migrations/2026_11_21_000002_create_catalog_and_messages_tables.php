<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('processors', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->string('manufacturer');
            $table->string('model');
            $table->timestamps();
        });
        Schema::create('operating_systems', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('notebooks', function (Blueprint $table) {
            $table->id();
            $table->string('manufacturer');
            $table->string('model');
            $table->decimal('screen_size', 4, 1);
            $table->unsignedSmallInteger('memory_mb');
            $table->unsignedSmallInteger('disk_gb');
            $table->string('graphics');
            $table->unsignedInteger('price');
            $table->unsignedInteger('processor_id');
            $table->unsignedInteger('operating_system_id');
            $table->timestamps();
            $table->foreign('processor_id')->references('id')->on('processors');
            $table->foreign('operating_system_id')->references('id')->on('operating_systems');
            $table->index('price');
        });
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('subject');
            $table->text('body');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
        Schema::dropIfExists('notebooks');
        Schema::dropIfExists('operating_systems');
        Schema::dropIfExists('processors');
    }
};
