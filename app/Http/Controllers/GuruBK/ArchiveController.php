<?php

namespace App\Http\Controllers\GuruBK;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Archive;
use App\Models\Letter;
use App\Models\CounselingSession;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ArchiveController extends Controller
{
    public function index(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        // Handle Surat (Letters) separately!
        if ($request->type === 'surat') {
            $lettersQuery = Letter::with('student.user')->where('teacher_id', $teacher->id);
            
            if ($request->filled('name')) {
                $searchName = $request->name;
                $lettersQuery->whereHas('student', function($q) use ($searchName) {
                    $q->where('name', 'like', '%' . $searchName . '%')
                      ->orWhereHas('user', function($q2) use ($searchName) {
                          $q2->where('name', 'like', '%' . $searchName . '%');
                      });
                });
            }
            
            if ($request->filled('date')) {
                $lettersQuery->whereDate('created_at', $request->date);
            }
            
            // Apply Academic Year and Semester filters
            $this->applyAcademicFilters($lettersQuery, 'created_at', $request);
            
            $letters = $lettersQuery->orderBy('created_at', 'desc')->get();
            
            // Group letters by Academic Year and Semester
            $groupedLetters = [];
            foreach ($letters as $letter) {
                $period = \App\Helpers\AcademicHelper::getAcademicPeriod($letter->created_at);
                $key = $period['academic_year'] . '_' . $period['semester'];
                if (!isset($groupedLetters[$key])) {
                    $groupedLetters[$key] = [
                        'label' => $period['label'],
                        'items' => []
                    ];
                }
                $groupedLetters[$key]['items'][] = $letter;
            }
            krsort($groupedLetters);
            
            $academicYears = \App\Helpers\AcademicHelper::getAcademicYearsList();
            
            return view('gurubk.archives.index', [
                'letters' => $groupedLetters,
                'academicYears' => $academicYears
            ]);
        }
        
        // Handle Konseling (Counseling Sessions) separately!
        if ($request->type === 'konseling') {
            $sessionsQuery = CounselingSession::with('student')->where('teacher_id', $teacher->id)->where('status', 'selesai');
            
            if ($request->filled('name')) {
                $searchName = $request->name;
                $sessionsQuery->whereHas('student', function($q) use ($searchName) {
                    $q->where('name', 'like', '%' . $searchName . '%');
                });
            }
            
            if ($request->filled('date')) {
                $sessionsQuery->whereDate('counseling_date', $request->date);
            }
            
            // Apply Academic Year and Semester filters
            $this->applyAcademicFilters($sessionsQuery, 'counseling_date', $request);
            
            $sessions = $sessionsQuery->orderBy('counseling_date', 'desc')->get();
            
            // Group sessions by Academic Year and Semester
            $groupedSessions = [];
            foreach ($sessions as $session) {
                $date = $session->completed_at ?? $session->counseling_date;
                $period = \App\Helpers\AcademicHelper::getAcademicPeriod($date);
                $key = $period['academic_year'] . '_' . $period['semester'];
                if (!isset($groupedSessions[$key])) {
                    $groupedSessions[$key] = [
                        'label' => $period['label'],
                        'items' => []
                    ];
                }
                $groupedSessions[$key]['items'][] = $session;
            }
            krsort($groupedSessions);
            
            $academicYears = \App\Helpers\AcademicHelper::getAcademicYearsList();
            
            return view('gurubk.archives.index', [
                'sessions' => $groupedSessions,
                'academicYears' => $academicYears
            ]);
        }
        
        // Handle normal consultation/reporting archives separately if requested explicitly
        if ($request->type === 'konsultasi' || $request->type === 'pelaporan') {
            $query = Archive::with(['student.user', 'report.reporter'])->where('teacher_id', $teacher->id);
            
            if ($request->filled('name')) {
                $searchName = $request->name;
                $query->whereHas('student', function($q) use ($searchName) {
                    $q->where('name', 'like', '%' . $searchName . '%')
                      ->orWhereHas('user', function($q2) use ($searchName) {
                          $q2->where('name', 'like', '%' . $searchName . '%');
                      });
                });
            }
            
            $query->whereHas('report', function($q) use ($request) {
                $q->where('type', $request->type);
            });

            if ($request->filled('date')) {
                $query->whereDate('completed_date', $request->date);
            }
            
            $query->whereNotNull('report_id');
            
            // Apply Academic Year and Semester filters
            $this->applyAcademicFilters($query, 'completed_date', $request);
            
            $archives = $query->orderBy('completed_date', 'desc')->get();
            
            // Group archives by Academic Year and Semester
            $groupedArchives = [];
            foreach ($archives as $archive) {
                $date = $archive->completed_date ?? $archive->created_at;
                $period = \App\Helpers\AcademicHelper::getAcademicPeriod($date);
                $key = $period['academic_year'] . '_' . $period['semester'];
                if (!isset($groupedArchives[$key])) {
                    $groupedArchives[$key] = [
                        'label' => $period['label'],
                        'items' => []
                    ];
                }
                $groupedArchives[$key]['items'][] = $archive;
            }
            krsort($groupedArchives);
            
            $academicYears = \App\Helpers\AcademicHelper::getAcademicYearsList();
            
            return view('gurubk.archives.index', [
                'archives' => $groupedArchives,
                'academicYears' => $academicYears
            ]);
        }

        // Handle "Semua Kasus" (All completed counseling sessions AND archived reports)
        $sessionsQuery = CounselingSession::with('student')
            ->where('teacher_id', $teacher->id)
            ->where('status', 'selesai');
        
        $archivesQuery = Archive::with(['student.user', 'report.reporter'])
            ->where('teacher_id', $teacher->id)
            ->whereNotNull('report_id');
            
        if ($request->filled('name')) {
            $searchName = $request->name;
            $sessionsQuery->whereHas('student', function($q) use ($searchName) {
                $q->where('name', 'like', '%' . $searchName . '%');
            });
            $archivesQuery->whereHas('student', function($q) use ($searchName) {
                $q->where('name', 'like', '%' . $searchName . '%')
                  ->orWhereHas('user', function($q2) use ($searchName) {
                      $q2->where('name', 'like', '%' . $searchName . '%');
                  });
            });
        }
        
        if ($request->filled('date')) {
            $sessionsQuery->whereDate('counseling_date', $request->date);
            $archivesQuery->whereDate('completed_date', $request->date);
        }
        
        // Apply Academic Year and Semester filters
        $this->applyAcademicFilters($sessionsQuery, 'counseling_date', $request);
        $this->applyAcademicFilters($archivesQuery, 'completed_date', $request);
        
        $completedSessions = $sessionsQuery->get();
        $archivesList = $archivesQuery->get();
        
        foreach ($completedSessions as $session) {
            $session->archive_sort_date = $session->completed_at ?? $session->counseling_date;
        }
        foreach ($archivesList as $archive) {
            $archive->archive_sort_date = $archive->completed_date ?? $archive->created_at;
        }
        
        $archives = $completedSessions->concat($archivesList)->sortByDesc(function($item) {
            return $item->archive_sort_date;
        });
        
        // Group all mixed archives by Academic Year and Semester
        $groupedArchives = [];
        foreach ($archives as $item) {
            $date = $item->archive_sort_date;
            $period = \App\Helpers\AcademicHelper::getAcademicPeriod($date);
            $key = $period['academic_year'] . '_' . $period['semester'];
            if (!isset($groupedArchives[$key])) {
                $groupedArchives[$key] = [
                    'label' => $period['label'],
                    'items' => []
                ];
            }
            $groupedArchives[$key]['items'][] = $item;
        }
        krsort($groupedArchives);
        
        $academicYears = \App\Helpers\AcademicHelper::getAcademicYearsList();
        
        return view('gurubk.archives.index', [
            'archives' => $groupedArchives,
            'academicYears' => $academicYears
        ]);
    }

    public function show(Archive $archive)
    {
        $teacher = Auth::user()->teacher;
        
        if ($archive->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to archive.');
        }

        $archive->load(['student.user', 'report.reporter', 'report.handler']);
        
        return view('gurubk.archives.show', compact('archive'));
    }

    public function export(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        $include_konseling = $request->has('konseling');
        $include_konsultasi = $request->has('konsultasi');
        $include_pelaporan = $request->has('pelaporan');
        $include_surat = $request->has('surat');
        
        $data = [];
        
        if ($include_konseling) {
            $query = CounselingSession::with('student')
                ->where('teacher_id', $teacher->id)
                ->where('status', 'selesai');
            $this->applyAcademicFilters($query, 'counseling_date', $request);
            $data['sessions'] = $query->orderBy('counseling_date', 'desc')->get();
        }
        
        if ($include_konsultasi || $include_pelaporan) {
            $types = [];
            if ($include_konsultasi) $types[] = 'konsultasi';
            if ($include_pelaporan) $types[] = 'pelaporan';
            
            $query = Archive::with(['student.user', 'report.reporter'])
                ->where('teacher_id', $teacher->id)
                ->whereHas('report', function($q) use ($types) {
                    $q->whereIn('type', $types);
                });
            $this->applyAcademicFilters($query, 'completed_date', $request);
            $data['archives'] = $query->orderBy('completed_date', 'desc')->get();
        }
        
        if ($include_surat) {
            $query = Letter::with('student.user')
                ->where('teacher_id', $teacher->id);
                
            if ($request->filled('letter_types')) {
                $query->whereIn('type', (array) $request->letter_types);
            }
            
            $this->applyAcademicFilters($query, 'created_at', $request);
            $data['letters'] = $query->orderBy('created_at', 'desc')->get();
        }
        
        $pdf = Pdf::loadView('gurubk.archives.export_pdf', compact('data', 'teacher'));
        $filename = 'Laporan_BK_' . now()->format('Ymd') . '.pdf';
        return $pdf->download($filename);
    }

    private function applyAcademicFilters($query, $dateField, Request $request)
    {
        if ($request->filled('academic_year')) {
            $yearParts = explode('/', $request->academic_year);
            if (count($yearParts) === 2) {
                $startYear = $yearParts[0];
                $endYear = $yearParts[1];
                
                if ($request->filled('semester')) {
                    $sem = $request->semester;
                    if ($sem == '1') {
                        $query->whereBetween($dateField, ["$startYear-07-01 00:00:00", "$startYear-12-31 23:59:59"]);
                    } elseif ($sem == '2') {
                        $query->whereBetween($dateField, ["$endYear-01-01 00:00:00", "$endYear-06-30 23:59:59"]);
                    }
                } else {
                    $query->whereBetween($dateField, ["$startYear-07-01 00:00:00", "$endYear-06-30 23:59:59"]);
                }
            }
        } elseif ($request->filled('semester')) {
            $sem = $request->semester;
            if ($sem == '1') {
                $query->whereMonth($dateField, '>=', 7)
                      ->whereMonth($dateField, '<=', 12);
            } elseif ($sem == '2') {
                $query->whereMonth($dateField, '>=', 1)
                      ->whereMonth($dateField, '<=', 6);
            }
        }
        return $query;
    }
}