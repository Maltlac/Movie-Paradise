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
        Schema::create('episode_series', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Series_id');
            $table->String('Saison');
            $table->String('nomEpisode');
            $table->time('duree');
            $table->text('resumeEpisode');
            $table->String('URLEpisode');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('episode_series');
    }
};
