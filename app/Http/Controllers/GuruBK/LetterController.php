<?php

namespace App\Http\Controllers\GuruBK;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\Letter;
use App\Models\Archive;
use App\Models\AcademicPeriod;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class LetterController extends Controller
{
    public function create(Request $request)
    {
        $teacher = Auth::user()->teacher;
        $students = Student::with('user')->where('teacher_id', $teacher->id)->get();
        $selectedStudentId = $request->query('student_id');
        return view('gurubk.letters.create', compact('students', 'selectedStudentId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'time' => 'nullable|string',
            'letter_number' => 'required|string|max:255',
            'room_select' => 'required|string',
            'room_manual' => 'nullable|string|max:255',
        ]);

        $teacher = Auth::user()->teacher;
        $student = $this->resolveStudent($request->student_id, $teacher);

        $room = $request->room_select === 'Lainnya' ? $request->room_manual : $request->room_select;

        $data = $this->buildLetterData($student, $teacher, $request->letter_number, [
            'date' => $request->date,
            'time' => $request->time ?? '09:00',
            'room' => $room,
        ]);

        $this->generateAndArchiveLetter(
            student: $student,
            teacher: $teacher,
            type: 'panggilan',
            viewName: 'gurubk.letters.pdf',
            filePrefix: 'surat_panggilan',
            archiveNote: 'Surat Panggilan Orang Tua',
            data: $data
        );

        return redirect()->route('gurubk.archives.index', ['type' => 'surat'])
            ->with('success', 'Surat panggilan berhasil dibuat dan diarsipkan.');
    }

    public function createSkorsing(Request $request)
    {
        $teacher = Auth::user()->teacher;
        $students = Student::with('user')->where('teacher_id', $teacher->id)->get();
        $selectedStudentId = $request->query('student_id');
        return view('gurubk.letters.skorsing_create', compact('students', 'selectedStudentId'));
    }

    public function storeSkorsing(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'letter_number' => 'required|string|max:255',
            'reason' => 'required|string',
            'duration' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $teacher = Auth::user()->teacher;
        $student = $this->resolveStudent($request->student_id, $teacher);

        $data = $this->buildLetterData($student, $teacher, $request->letter_number, [
            'reason' => $request->reason,
            'duration' => $request->duration,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        $this->generateAndArchiveLetter(
            student: $student,
            teacher: $teacher,
            type: 'skorsing',
            viewName: 'gurubk.letters.skorsing_pdf',
            filePrefix: 'surat_skorsing',
            archiveNote: 'Surat Pemberitahuan Skorsing: ' . $request->reason . ' (' . $request->duration . ' hari)',
            data: $data
        );

        return redirect()->route('gurubk.archives.index', ['type' => 'surat'])
            ->with('success', 'Surat skorsing berhasil dibuat dan diarsipkan.');
    }

    public function createSp1(Request $request)
    {
        $teacher = Auth::user()->teacher;
        $students = Student::with('user')->where('teacher_id', $teacher->id)->get();
        $selectedStudentId = $request->query('student_id');
        return view('gurubk.letters.sp1_create', compact('students', 'selectedStudentId'));
    }

    public function storeSp1(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'letter_number' => 'required|string|max:255',
            'reason' => 'required|string',
        ]);

        $teacher = Auth::user()->teacher;
        $student = $this->resolveStudent($request->student_id, $teacher);

        $data = $this->buildLetterData($student, $teacher, $request->letter_number, [
            'reason' => $request->reason,
        ]);

        $this->generateAndArchiveLetter(
            student: $student,
            teacher: $teacher,
            type: 'sp1',
            viewName: 'gurubk.letters.sp1_pdf',
            filePrefix: 'surat_sp1',
            archiveNote: 'Surat Peringatan Pertama (SP1): ' . $request->reason,
            data: $data
        );

        return redirect()->route('gurubk.archives.index', ['type' => 'surat'])
            ->with('success', 'Surat SP1 berhasil dibuat dan diarsipkan.');
    }

    public function createSp2(Request $request)
    {
        $teacher = Auth::user()->teacher;
        $students = Student::with('user')->where('teacher_id', $teacher->id)->get();
        $selectedStudentId = $request->query('student_id');
        return view('gurubk.letters.sp2_create', compact('students', 'selectedStudentId'));
    }

    public function storeSp2(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'letter_number' => 'required|string|max:255',
            'reason' => 'required|string',
        ]);

        $teacher = Auth::user()->teacher;
        $student = $this->resolveStudent($request->student_id, $teacher);

        $data = $this->buildLetterData($student, $teacher, $request->letter_number, [
            'reason' => $request->reason,
        ]);

        $this->generateAndArchiveLetter(
            student: $student,
            teacher: $teacher,
            type: 'sp2',
            viewName: 'gurubk.letters.sp2_pdf',
            filePrefix: 'surat_sp2',
            archiveNote: 'Surat Peringatan Kedua (SP2): ' . $request->reason,
            data: $data
        );

        return redirect()->route('gurubk.archives.index', ['type' => 'surat'])
            ->with('success', 'Surat SP2 berhasil dibuat dan diarsipkan.');
    }

    // =========================================================================
    // Private Helper Methods (DRY extraction)
    // =========================================================================

    /**
     * Resolve and authorize student ownership.
     */
    private function resolveStudent(int $studentId, $teacher): Student
    {
        $student = Student::with('user')->findOrFail($studentId);

        if ($student->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to student.');
        }

        return $student;
    }

    /**
     * Build common letter data array with student and teacher information.
     */
    private function buildLetterData(Student $student, $teacher, string $letterNumber, array $extra = []): array
    {
        $studentName = $student->name ?? ($student->user ? $student->user->name : 'Tanpa Nama');
        $fullLetterNumber = trim($letterNumber);

        return array_merge([
            'student_name' => $studentName,
            'nisn' => $student->nisn,
            'class' => $student->class,
            'gender' => $student->gender,
            'father_name' => $student->father_name,
            'mother_name' => $student->mother_name,
            'parents_address' => $student->parents_address ?? $student->address,
            'teacher_name' => $teacher->user->name,
            'nip' => $teacher->nip,
            'letter_number' => $fullLetterNumber,
        ], $extra);
    }

    /**
     * Generate PDF, save to storage, create Letter & Archive records.
     */
    private function generateAndArchiveLetter(
        Student $student,
        $teacher,
        string $type,
        string $viewName,
        string $filePrefix,
        string $archiveNote,
        array $data
    ): void {
        $studentName = $data['student_name'];

        $pdf = Pdf::loadView($viewName, $data);
        
        $fileName = $filePrefix . '_' . Str::slug($studentName) . '_' . time() . '.pdf';
        $filePath = 'letters/' . $fileName;
        
        \Illuminate\Support\Facades\Storage::disk('public')->put($filePath, $pdf->output());

        $activePeriod = AcademicPeriod::active();

        Letter::create([
            'academic_period_id' => $activePeriod?->id,
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'type' => $type,
            'file_path' => $filePath,
            'content_json' => $data,
        ]);

        Archive::create([
            'academic_period_id' => $activePeriod?->id,
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'handler_name' => $teacher->user->name ?? 'Guru BK',
            'guidance_notes' => $archiveNote,
            'completed_date' => now(),
            'attachment_path' => $filePath,
        ]);
    }
}
