<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kandidat_aftesite', function (Blueprint $table) {
            $table->id('ka_id');
            $table->foreignId('kandidat_id')->constrained('kandidatet')->onDelete('cascade');
            $table->foreignId('aftesi_id')->constrained('aftesite')->onDelete('cascade');
            $table->enum('niveli', ['fillestar', 'mesem', 'avancuar', 'ekspert'])->default('fillestar');
            $table->unique(['kandidat_id', 'aftesi_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kandidat_aftesite');
    }
};
