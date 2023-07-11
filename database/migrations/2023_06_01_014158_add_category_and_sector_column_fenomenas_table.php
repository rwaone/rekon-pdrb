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
        Schema::table('fenomenas', function (Blueprint $table) {
            $table->char('type', 25)->after('id');
            $table->year('year')->after('type');
            $table->char('quarter', 1)->after('year');
            $table->foreignId('sector_id')->after('region_id')->nullable(true);
            $table->foreignId('category_id')->after('region_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fenomenas', function (Blueprint $table) {
            $table->dropColumn('category_id', 'sector_id', 'period_id');
        });
    }
};
