<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->updateClassNames();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No easy way to perfectly reverse without keeping old states
    }

    private function updateClassNames()
    {
        // Get all unique classes currently in database from both tables
        $studentClasses = DB::table('students')->whereNotNull('class')->distinct()->pluck('class')->toArray();
        $assignmentClasses = DB::table('teacher_class_assignments')->distinct()->pluck('class')->toArray();
        
        $allUniqueClasses = array_unique(array_merge($studentClasses, $assignmentClasses));

        foreach ($allUniqueClasses as $oldClass) {
            $newClass = $this->mapClass($oldClass);
            if ($newClass && $newClass !== $oldClass) {
                // Update in students table
                DB::table('students')
                    ->where('class', $oldClass)
                    ->update(['class' => $newClass]);

                // Update in teacher_class_assignments table
                // Note: unique constraint exists on [academic_period_id, class].
                // So if the new class name already exists for the same academic_period_id, 
                // we should handle it to prevent duplication errors.
                $assignments = DB::table('teacher_class_assignments')
                    ->where('class', $oldClass)
                    ->get();
                
                foreach ($assignments as $assignment) {
                    $exists = DB::table('teacher_class_assignments')
                        ->where('academic_period_id', $assignment->academic_period_id)
                        ->where('class', $newClass)
                        ->exists();
                    
                    if ($exists) {
                        // Delete the duplicate assignment
                        DB::table('teacher_class_assignments')
                            ->where('id', $assignment->id)
                            ->delete();
                    } else {
                        DB::table('teacher_class_assignments')
                            ->where('id', $assignment->id)
                            ->update(['class' => $newClass]);
                    }
                }
            }
        }
    }

    private function mapClass($class)
    {
        if (empty($class)) {
            return null;
        }

        $cleaned = strtoupper(trim($class));
        $cleaned = str_replace(' ', '', $cleaned); // Remove spaces

        // Identify grade level
        $grade = null;
        if (str_starts_with($cleaned, 'VIII') || str_starts_with($cleaned, '8')) {
            $grade = '8';
        } elseif (str_starts_with($cleaned, 'VII') || str_starts_with($cleaned, '7')) {
            $grade = '7';
        } elseif (str_starts_with($cleaned, 'IX') || str_starts_with($cleaned, '9')) {
            $grade = '9';
        }

        if (!$grade) {
            return $class; // Return unchanged if grade can't be identified
        }

        // Extract the section part (suffix)
        // E.g., VII-A -> A, VII-1 -> 1, 7A -> A, VIIA -> A
        $suffix = preg_replace('/^(VIII|VII|IX|7|8|9)-?/i', '', $cleaned);

        $sections = [
            'A' => 'andalan',
            '1' => 'andalan',
            'B' => 'budi pekerti',
            '2' => 'budi pekerti',
            'C' => 'tut wuri handayani',
            '3' => 'tut wuri handayani',
            'D' => 'kebangsaan',
            '4' => 'kebangsaan',
            'E' => 'ki hajar dewantara',
            '5' => 'ki hajar dewantara',
            'F' => 'merdeka',
            '6' => 'merdeka',
            'G' => 'kebanggaan',
            '7' => 'kebanggaan',
            'H' => 'harmonis',
            '8' => 'harmonis',
        ];

        if (isset($sections[$suffix])) {
            return $grade . ' ' . $sections[$suffix];
        }

        // Suffix might be full name already, let's normalize it if it matches any target
        $fullNames = [
            'ANDALAN' => 'andalan',
            'BUDIPEKERTI' => 'budi pekerti',
            'TUTWURIHANDAYANI' => 'tut wuri handayani',
            'KEBANGSAAN' => 'kebangsaan',
            'KIHAJARDEWANTARA' => 'ki hajar dewantara',
            'MERDEKA' => 'merdeka',
            'KEBANGGAAN' => 'kebanggaan',
            'HARMONIS' => 'harmonis',
        ];

        if (isset($fullNames[$suffix])) {
            return $grade . ' ' . $fullNames[$suffix];
        }

        // Default: If suffix is not recognized, try to guess or keep original suffix
        return $class;
    }
};
