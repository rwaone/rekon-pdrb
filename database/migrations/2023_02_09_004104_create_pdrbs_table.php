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
            $table->foreignId('dataset_id');
            $table->year('year');
            $table->char('quarter', 1);
            $table->foreignId('subsector_id');
            $table->decimal('adhb', $precision = 19, $scale = 9)->default(0);
            $table->decimal('adhk', $precision = 19, $scale = 9)->default(0);
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
