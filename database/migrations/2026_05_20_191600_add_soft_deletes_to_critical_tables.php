<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add soft delete columns to critical tables.
     * This prevents permanent data loss when records are deleted.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('archives', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('counseling_sessions', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('archives', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('counseling_sessions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
