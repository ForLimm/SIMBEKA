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
        Schema::table('counseling_sessions', function (Blueprint $table) {
            $table->foreignId('academic_period_id')->nullable()->after('id')
                  ->constrained('academic_periods')->onDelete('set null');
        });

        Schema::table('archives', function (Blueprint $table) {
            $table->foreignId('academic_period_id')->nullable()->after('id')
                  ->constrained('academic_periods')->onDelete('set null');
        });

        Schema::table('letters', function (Blueprint $table) {
            $table->foreignId('academic_period_id')->nullable()->after('id')
                  ->constrained('academic_periods')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('counseling_sessions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('academic_period_id');
        });

        Schema::table('archives', function (Blueprint $table) {
            $table->dropConstrainedForeignId('academic_period_id');
        });

        Schema::table('letters', function (Blueprint $table) {
            $table->dropConstrainedForeignId('academic_period_id');
        });
    }
};
