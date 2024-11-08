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
        Schema::create('vikor_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesantren_id')->constrained()->onDelete('cascade');
            $table->decimal('vikor_score', 8, 4);
            $table->integer('rank');
            $table->timestamps();

            // unique constraint for latest result per school
            $table->unique('pesantren_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vikor_results');
    }
};
