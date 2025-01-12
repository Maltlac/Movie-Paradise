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
        Schema::create('commantaires', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('Corp');
            $table->integer('note');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('film_id')->nullable();
            $table->unsignedBigInteger('series_id')->nullable();
            $table->date('datePost');

            $table->index('film_id');
            $table->index('series_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commantaires');
    }
};
