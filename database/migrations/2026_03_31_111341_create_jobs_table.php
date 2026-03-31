<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->unsignedInteger('salary_min');
            $table->unsignedInteger('salary_max');
            $table->string('location');
            $table->enum('experience', ['entry', 'intermediate', 'senior']);
            $table->enum('type', ['full-time', 'part-time', 'remote', 'internship']);
            $table->boolean('is_active')->default(true);
            $table->index(['category_id', 'experience', 'is_active']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};