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
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tmdb_id');
            $table->unsignedBigInteger('saisons_id');
            $table->string('titre')->nullable();
            $table->text('resume')->nullable();
            $table->string('image')->nullable();
            $table->String('numeroEpisode')->nullable();
            $table->date('dateSortie');
            $table->time('duree')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('episodes');
    }
};
