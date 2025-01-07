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
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->String('titre');
          //  $table->unsignedBigInteger('realisateurs_id');
            $table->date('dateSortie');
            $table->text('resume');
            $table->String('image');
            $table->unsignedBigInteger('tmdb_id');
            $table->String('urlTrailler');
            $table->timestamps();

            $table->index('realisateurs_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};
