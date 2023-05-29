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
    public function up()
    {
        Schema::create('pdrbs', function (Blueprint $table) {
            $table->id();
            $table->char('type', 25)->nullable(true);
            $table->foreignId('period_id');
            $table->foreignId('region_id');
            $table->foreignId('subsector_id');
            $table->decimal('adhb', $precision = 10, $scale = 2)->nullable(true);
            $table->decimal('adhk', $precision = 10, $scale = 2)->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pdrbs');
    }
};
