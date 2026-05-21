<?php

namespace App\Http\Controllers\GuruBK;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AnecdoteController extends Controller
{
    public function export(Request $request)
    {
        $teacher = Auth::user()?->teacher;

        if (! $teacher) {
            return back()->with('error', 'Akun Anda tidak terhubung ke data guru BK.');
        }
        
        $query = Student::with(['counselingSessions' => function($q) use ($teacher, $request) {
            $q->where('teacher_id', $teacher->id)
              ->orderBy('counseling_date', 'asc');
              
            if ($request->period === 'month') {
                $q->whereMonth('counseling_date', Carbon::now()->month)
                  ->whereYear('counseling_date', Carbon::now()->year);
            } elseif ($request->period === 'semester') {
                $month = Carbon::now()->month;
                $year = Carbon::now()->year;
                if ($month >= 7 && $month <= 12) {
                    // Ganjil
                    $q->whereMonth('counseling_date', '>=', 7)
                      ->whereYear('counseling_date', $year);
                } else {
                    // Genap
                    $q->whereMonth('counseling_date', '<=', 6)
                      ->whereYear('counseling_date', $year);
                }
            } elseif ($request->period === 'year') {
                [$start, $end] = $this->academicYearRange(Carbon::now());
                $q->whereBetween('counseling_date', [$start, $end]);
            }
        }])->where('teacher_id', $teacher->id);
        
        if ($request->has('student_id')) {
            $query->where('id', $request->student_id);
            $filenamePrefix = 'Laporan_Anekdot_Individu_';
        } elseif ($request->has('student_ids')) {
            $ids = explode(',', $request->student_ids);
            $totalTeacherStudents = Student::where('teacher_id', $teacher->id)->count();

            if (count($ids) == 1) {
                $query->where('id', $ids[0]);
                $filenamePrefix = 'Laporan_Anekdot_Individu_';
            } elseif (count($ids) == $totalTeacherStudents) {
                // Treats as Keseluruhan, no need for whereIn filter
                $filenamePrefix = 'Laporan_Anekdot_Keseluruhan_';
            } else {
                $query->whereIn('id', $ids);
                $filenamePrefix = 'Laporan_Anekdot_Terpilih_';
            }
        } else {
            $filenamePrefix = 'Laporan_Anekdot_Keseluruhan_';
        }
        
        $students = $query->get();
        
        $period = $request->period ?? 'all';

        $data = [
            'students' => $students,
            'teacher' => $teacher,
            'period' => $period,
            'periodLabel' => $this->resolvePeriodLabel($period),
        ];
        
        $filename = $filenamePrefix . now()->format('Ymd');

        if ($request->format === 'word') {
            return $this->downloadHtmlAs(
                $data,
                $filename . '.doc',
                'application/msword'
            );
        }

        if ($request->format === 'excel') {
            return $this->downloadHtmlAs(
                $data,
                $filename . '.xls',
                'application/vnd.ms-excel'
            );
        }

        if ($request->format === 'pdf') {
            return Pdf::loadView('gurubk.exports.anecdote', $data)
                ->download($filename . '.pdf');
        }

        return back()->with('error', 'Format ekspor tidak valid.');
    }

    private function downloadHtmlAs(array $data, string $filename, string $contentType)
    {
        $html = view('gurubk.exports.anecdote', $data)->render();

        return response()->streamDownload(
            fn () => print($html),
            $filename,
            ['Content-Type' => $contentType]
        );
    }

    private function resolvePeriodLabel(string $period): string
    {
        $now = Carbon::now();

        return match ($period) {
            'month' => $now->translatedFormat('F Y'),
            'semester' => $this->semesterLabel($now),
            'year' => $this->academicYearLabel($now),
            default => 'Seluruh Data',
        };
    }

    private function semesterLabel(Carbon $date): string
    {
        // Semester 1 (ganjil): Juli–Desember | Semester 2 (genap): Januari–Juni
        if ($date->month >= 7) {
            return 'Semester 1 ' . $date->year;
        }

        return 'Semester 2 ' . $date->year;
    }

    private function academicYearLabel(Carbon $date): string
    {
        if ($date->month >= 7) {
            return 'Tahun Ajaran ' . $date->year . '/' . ($date->year + 1);
        }

        return 'Tahun Ajaran ' . ($date->year - 1) . '/' . $date->year;
    }

    /**
     * @return array{0: Carbon, 1: Carbon}
     */
    private function academicYearRange(Carbon $date): array
    {
        if ($date->month >= 7) {
            $start = $date->copy()->month(7)->day(1)->startOfDay();
            $end = $date->copy()->addYear()->month(6)->day(30)->endOfDay();
        } else {
            $start = $date->copy()->subYear()->month(7)->day(1)->startOfDay();
            $end = $date->copy()->month(6)->day(30)->endOfDay();
        }

        return [$start, $end];
    }
}