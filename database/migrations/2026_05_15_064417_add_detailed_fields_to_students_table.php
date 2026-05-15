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
        Schema::table('students', function (Blueprint $table) {
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('gender')->nullable();
            $table->string('religion')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('parents_job')->nullable();
            $table->string('parents_phone')->nullable();
            $table->text('parents_address')->nullable();
            $table->string('living_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'birth_place', 'birth_date', 'gender', 'religion', 'address', 'phone',
                'father_name', 'mother_name', 'parents_job', 'parents_phone', 'parents_address', 'living_status'
            ]);
        });
    }
};
