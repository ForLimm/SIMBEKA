<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add indexes to frequently queried columns for better query performance.
     * These columns are used in WHERE clauses across dashboards, filters, and reports.
     */
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->index('reported_by');
            $table->index('status');
            $table->index('type');
            $table->index(['status', 'handled_by']); // composite: dashboard queries
        });

        Schema::table('students', function (Blueprint $table) {
            $table->index('teacher_id');
        });

        Schema::table('archives', function (Blueprint $table) {
            $table->index('teacher_id');
            $table->index('completed_date');
        });

        Schema::table('counseling_sessions', function (Blueprint $table) {
            $table->index('teacher_id');
            $table->index('status');
            $table->index('counseling_date');
        });

        Schema::table('chat_messages', function (Blueprint $table) {
            $table->index(['report_id', 'is_destroyed']); // composite: visible messages query
        });

        Schema::table('letters', function (Blueprint $table) {
            $table->index('teacher_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropIndex(['reported_by']);
            $table->dropIndex(['status']);
            $table->dropIndex(['type']);
            $table->dropIndex(['status', 'handled_by']);
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropIndex(['teacher_id']);
        });

        Schema::table('archives', function (Blueprint $table) {
            $table->dropIndex(['teacher_id']);
            $table->dropIndex(['completed_date']);
        });

        Schema::table('counseling_sessions', function (Blueprint $table) {
            $table->dropIndex(['teacher_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['counseling_date']);
        });

        Schema::table('chat_messages', function (Blueprint $table) {
            $table->dropIndex(['report_id', 'is_destroyed']);
        });

        Schema::table('letters', function (Blueprint $table) {
            $table->dropIndex(['teacher_id']);
        });
    }
};
