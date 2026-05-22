<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('academic_periods', function (Blueprint $table) {
            $table->id();
            $table->string('name');                       // "2025/2026 - Semester 1"
            $table->string('academic_year');               // "2025/2026"
            $table->enum('semester', ['1', '2']);          // 1 = Ganjil, 2 = Genap
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_active')->default(false);
            $table->timestamps();

            $table->unique(['academic_year', 'semester']);
        });

        // Seed an initial period based on the current date
        $now = Carbon::now();
        if ($now->month >= 7 && $now->month <= 12) {
            DB::table('academic_periods')->insert([
                'name' => $now->year . '/' . ($now->year + 1) . ' - Semester 1',
                'academic_year' => $now->year . '/' . ($now->year + 1),
                'semester' => '1',
                'start_date' => $now->year . '-07-01',
                'end_date' => $now->year . '-12-31',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            DB::table('academic_periods')->insert([
                'name' => ($now->year - 1) . '/' . $now->year . ' - Semester 2',
                'academic_year' => ($now->year - 1) . '/' . $now->year,
                'semester' => '2',
                'start_date' => $now->year . '-01-01',
                'end_date' => $now->year . '-06-30',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_periods');
    }
};
