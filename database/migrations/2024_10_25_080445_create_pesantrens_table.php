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
        Schema::create('pesantrens', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('long')->nullable();
            $table->string('latt')->nullable();
            $table->integer('biaya_bulanan');
            $table->string('akreditasi');
            $table->integer('total_students');
            $table->text('other_details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesantrens');
    }
};
