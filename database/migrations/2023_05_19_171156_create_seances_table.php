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
        Schema::create('seances', function (Blueprint $table) {
            $table->id();
            $table->time('heured');
            $table->time('heuref');
            $table->unsignedBigInteger('film_id');
            $table->unsignedBigInteger('cinema_id');
            $table->string('lang');
            $table->timestamps();

            $table->index("film_id");
            $table->index("cinema_id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seances');
    }
};
