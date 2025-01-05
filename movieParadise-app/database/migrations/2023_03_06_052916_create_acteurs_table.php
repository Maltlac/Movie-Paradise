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
        Schema::create('acteurs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('bio');
            $table->string('image');
            $table->date('dateNaissance');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acteurs');
    }
};
