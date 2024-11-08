<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('criterias', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('weight', 5, 2);
            $table->timestamps();
        });

        // insert default criteria
        DB::table('criterias')->insert([
            ['name' => 'facility', 'weight' => 1.0],
            ['name' => 'learning_method', 'weight' => 1.0],
            ['name' => 'extracurricular', 'weight' => 1.0]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criterias');
    }
};
