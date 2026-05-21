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
            $table->string('title')->nullable()->after('teacher_id');
            $table->string('category')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('counseling_sessions', function (Blueprint $table) {
            $table->dropColumn('title');
            // Changing string back to enum might throw errors depending on database engine,
            // but we can define it or just do nothing if not strictly needed.
            // Let's leave category as string in down or drop if needed, but dropping is safer or keep it.
        });
    }
};
