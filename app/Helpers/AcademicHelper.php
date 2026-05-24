<?php

namespace App\Helpers;

use Carbon\Carbon;

class AcademicHelper
{
    /**
     * Get academic period information based on a date.
     *
     * @param string|\Carbon\Carbon $date
     * @return array
     */
    public static function getAcademicPeriod($date): array
    {
        $carbonDate = Carbon::parse($date);
        $year = $carbonDate->year;
        $month = $carbonDate->month;

        if ($month >= 7 && $month <= 12) {
            $semester = '1';
            $academicYear = $year . '/' . ($year + 1);
        } else {
            $semester = '2';
            $academicYear = ($year - 1) . '/' . $year;
        }

        return [
            'semester' => $semester,
            'academic_year' => $academicYear,
            'label' => "Semester $semester (TA $academicYear)"
        ];
    }

    /**
     * Get list of academic years.
     *
     * @return array
     */
    public static function getAcademicYearsList(): array
    {
        $currentYear = (int) date('Y');
        $years = [];
        for ($y = 2024; $y <= $currentYear + 1; $y++) {
            $years[] = $y . '/' . ($y + 1);
        }
        return $years;
    }
}
