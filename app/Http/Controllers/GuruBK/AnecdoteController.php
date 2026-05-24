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
              
            if ($request->filled('academic_year') || $request->filled('semester')) {
                if ($request->filled('academic_year')) {
                    $yearParts = explode('/', $request->academic_year);
                    if (count($yearParts) === 2) {
                        $startYear = $yearParts[0];
                        $endYear = $yearParts[1];
                        
                        if ($request->filled('semester')) {
                            $sem = $request->semester;
                            if ($sem == '1') {
                                $q->whereBetween('counseling_date', ["$startYear-07-01 00:00:00", "$startYear-12-31 23:59:59"]);
                            } elseif ($sem == '2') {
                                $q->whereBetween('counseling_date', ["$endYear-01-01 00:00:00", "$endYear-06-30 23:59:59"]);
                            }
                        } else {
                            $q->whereBetween('counseling_date', ["$startYear-07-01 00:00:00", "$endYear-06-30 23:59:59"]);
                        }
                    }
                } elseif ($request->filled('semester')) {
                    $sem = $request->semester;
                    if ($sem == '1') {
                        $q->whereMonth('counseling_date', '>=', 7)
                          ->whereMonth('counseling_date', '<=', 12);
                    } elseif ($sem == '2') {
                        $q->whereMonth('counseling_date', '>=', 1)
                          ->whereMonth('counseling_date', '<=', 6);
                    }
                }
            } else {
                $period = $request->period ?? 'semester';
                
                if ($period === 'month') {
                    $q->whereMonth('counseling_date', Carbon::now()->month)
                      ->whereYear('counseling_date', Carbon::now()->year);
                } elseif ($period === 'semester') {
                    $now = Carbon::now();
                    if ($now->month >= 7 && $now->month <= 12) {
                        $q->whereBetween('counseling_date', ["{$now->year}-07-01 00:00:00", "{$now->year}-12-31 23:59:59"]);
                    } else {
                        $q->whereBetween('counseling_date', ["{$now->year}-01-01 00:00:00", "{$now->year}-06-30 23:59:59"]);
                    }
                } elseif ($period === 'year') {
                    [$start, $end] = $this->academicYearRange(Carbon::now());
                    $q->whereBetween('counseling_date', [$start, $end]);
                }
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
                $filenamePrefix = 'Laporan_Anekdot_Keseluruhan_';
            } else {
                $query->whereIn('id', $ids);
                $filenamePrefix = 'Laporan_Anekdot_Terpilih_';
            }
        } else {
            $filenamePrefix = 'Laporan_Anekdot_Keseluruhan_';
        }
        
        $students = $query->get();
        
        $period = $request->period ?? 'semester';
 
        $data = [
            'students' => $students,
            'teacher' => $teacher,
            'period' => $period,
            'periodLabel' => $this->resolvePeriodLabel($request),
        ];
        
        $filename = $filenamePrefix . now()->format('Ymd');
 
        if ($request->format === 'word') {
            $html = view('gurubk.exports.anecdote', $data)->render();
            return response($html)
                ->header('Content-Type', 'application/msword')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '.doc"');
        }

        if ($request->format === 'excel') {
            $html = view('gurubk.exports.anecdote', $data)->render();
            return response($html)
                ->header('Content-Type', 'application/vnd.ms-excel')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '.xls"');
        }

        return Pdf::loadView('gurubk.exports.anecdote', $data)
            ->download($filename . '.pdf');
    }
 
    private function resolvePeriodLabel(Request $request): string
    {
        if ($request->filled('academic_year') || $request->filled('semester')) {
            $label = '';
            if ($request->filled('semester')) {
                $label .= 'Semester ' . $request->semester;
            }
            if ($request->filled('academic_year')) {
                if ($label) {
                    $label .= ' (TA ' . $request->academic_year . ')';
                } else {
                    $label .= 'Tahun Ajaran ' . $request->academic_year;
                }
            }
            return $label;
        }

        $now = Carbon::now();
        $period = $request->period ?? 'semester';
 
        return match ($period) {
            'month' => $now->translatedFormat('F Y'),
            'semester' => $this->semesterLabel($now),
            'year' => $this->academicYearLabel($now),
            default => 'Seluruh Data',
        };
    }
 
    private function semesterLabel(Carbon $date): string
    {
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