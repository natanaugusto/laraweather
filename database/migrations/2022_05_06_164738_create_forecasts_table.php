<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(table: 'forecasts', callback: function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'city_id')->constrained(table: 'cities');
            $table->string(column: 'description');
            $table->float(column: 'min', total: 5);
            $table->float(column: 'max', total: 5);
            $table->float(column: 'feels', total: 5);
            $table->dateTime(column: 'last_update');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'forecasts');
    }
};
