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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('wallet')->comment('количество денег на заправку');
            $table->foreignId('fuel_id')->constrained('fuels')->comment('"внешний ключ" для массива с резервуарами');
            $table->integer('fuel_tank')->comment('объем бака');
            $table->integer('fuel_rest')->comment('остаток топлива');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
