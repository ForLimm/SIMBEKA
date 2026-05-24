<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Fix CASCADE DELETE rules that would cause catastrophic data loss.
     * 
     * Problem: When a teacher/user is deleted, all related student data,
     * counseling records, letters, archives, and reports are permanently
     * destroyed due to incorrect CASCADE rules.
     * 
     * Solution: Change to SET NULL so historical records are preserved
     * and only the FK reference is cleared.
     * 
     * Also enlarges recovery_code column to TEXT to accommodate encrypted values.
     */
    public function up(): void
    {
        // 1. students.teacher_id: CASCADE → SET NULL
        //    Alasan: Siswa tidak boleh terhapus hanya karena guru pembimbing dihapus.
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->foreign('teacher_id')
                  ->references('id')->on('teachers')
                  ->onDelete('set null');
        });

        // 2. reports.handled_by: CASCADE → SET NULL
        //    Alasan: Laporan adalah data historis, tidak boleh hilang.
        Schema::table('reports', function (Blueprint $table) {
            $table->dropForeign(['handled_by']);
            $table->foreign('handled_by')
                  ->references('id')->on('users')
                  ->onDelete('set null');
        });

        // 3. archives.teacher_id: CASCADE → SET NULL
        //    Alasan: Arsip kasus adalah rekam jejak resmi sekolah.
        Schema::table('archives', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->unsignedBigInteger('teacher_id')->nullable()->change();
            $table->foreign('teacher_id')
                  ->references('id')->on('teachers')
                  ->onDelete('set null');
        });

        // 4. counseling_sessions.teacher_id: CASCADE → SET NULL
        //    Alasan: Data konseling siswa harus tetap ada meski guru pindah/dihapus.
        //    Sudah ada teacher_name & teacher_nip sebagai snapshot historis.
        Schema::table('counseling_sessions', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->unsignedBigInteger('teacher_id')->nullable()->change();
            $table->foreign('teacher_id')
                  ->references('id')->on('teachers')
                  ->onDelete('set null');
        });

        // 5. letters.teacher_id: CASCADE → SET NULL
        //    Alasan: Surat peringatan adalah dokumen resmi sekolah.
        Schema::table('letters', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->unsignedBigInteger('teacher_id')->nullable()->change();
            $table->foreign('teacher_id')
                  ->references('id')->on('teachers')
                  ->onDelete('set null');
        });

        // 6. Perbesar recovery_code dari varchar(255) ke text
        //    Alasan: Nilai terenkripsi (Crypt::encryptString) menghasilkan 
        //    string base64 yang melebihi 255 karakter.
        Schema::table('users', function (Blueprint $table) {
            $table->text('recovery_code')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->foreign('teacher_id')
                  ->references('id')->on('teachers')
                  ->onDelete('cascade');
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->dropForeign(['handled_by']);
            $table->foreign('handled_by')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });

        Schema::table('archives', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->unsignedBigInteger('teacher_id')->nullable(false)->change();
            $table->foreign('teacher_id')
                  ->references('id')->on('teachers')
                  ->onDelete('cascade');
        });

        Schema::table('counseling_sessions', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->unsignedBigInteger('teacher_id')->nullable(false)->change();
            $table->foreign('teacher_id')
                  ->references('id')->on('teachers')
                  ->onDelete('cascade');
        });

        Schema::table('letters', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->unsignedBigInteger('teacher_id')->nullable(false)->change();
            $table->foreign('teacher_id')
                  ->references('id')->on('teachers')
                  ->onDelete('cascade');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('recovery_code')->nullable()->change();
        });
    }
};
