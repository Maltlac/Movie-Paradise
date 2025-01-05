<?php

use Illuminate\Database\DBAL\TimestampType;
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
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('realisateurs_id');
            $table->unsignedBigInteger('tmdb_id');
            $table->string('titre')->nullable();
            $table->time('duree')->nullable();
            $table->text('resume')->nullable();
            $table->string('image')->nullable();
            $table->date('dateSortie');
            $table->text('urlTrailler')->nullable();
            $table->timestamps();

            $table->index('realisateurs_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};
