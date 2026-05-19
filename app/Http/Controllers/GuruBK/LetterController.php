<?php

namespace App\Http\Controllers\GuruBK;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\Letter;
use App\Models\Archive;
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
            'reason' => 'required|string',
            'letter_number' => 'required|string|max:10',
        ]);

        $teacher = Auth::user()->teacher;
        $student = Student::with('user')->findOrFail($request->student_id);

        if ($student->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to student.');
        }

        // Safe name resolution
        $studentName = $student->name ?? ($student->user ? $student->user->name : 'Tanpa Nama');

        $fullLetterNumber = '421.7 / ' . trim($request->letter_number) . ' / SMP.06 / ' . date('Y');

        $data = [
            'student_name' => $studentName,
            'nisn' => $student->nisn,
            'class' => $student->class,
            'gender' => $student->gender,
            'father_name' => $student->father_name,
            'mother_name' => $student->mother_name,
            'parents_address' => $student->parents_address ?? $student->address,
            'date' => $request->date,
            'time' => $request->time ?? '09:00',
            'reason' => $request->reason,
            'teacher_name' => $teacher->user->name,
            'nip' => $teacher->nip,
            'letter_number' => $fullLetterNumber,
        ];

        $pdf = Pdf::loadView('gurubk.letters.pdf', $data);
        
        $fileName = 'surat_panggilan_' . Str::slug($studentName) . '_' . time() . '.pdf';
        $filePath = 'letters/' . $fileName;
        
        \Illuminate\Support\Facades\Storage::disk('public')->put($filePath, $pdf->output());

        $letter = Letter::create([
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'type' => 'panggilan',
            'file_path' => $filePath,
            'content_json' => $data,
        ]);

        Archive::create([
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'guidance_notes' => 'Surat Panggilan Orang Tua: ' . $request->reason,
            'completed_date' => now(),
            'attachment_path' => $filePath,
        ]);

        return redirect()->route('gurubk.archives.index', ['type' => 'surat'])
            ->with('success', 'Surat panggilan berhasil dibuat dan diarsipkan.')
            ->with('download_pdf_path', asset('storage/' . $filePath));
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
            'letter_number' => 'required|string|max:10',
            'reason' => 'required|string',
            'duration' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $teacher = Auth::user()->teacher;
        $student = Student::with('user')->findOrFail($request->student_id);

        if ($student->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to student.');
        }

        $studentName = $student->name ?? ($student->user ? $student->user->name : 'Tanpa Nama');

        $fullLetterNumber = '421.7 / ' . trim($request->letter_number) . ' / SMP.06 / ' . date('Y');

        $data = [
            'student_name' => $studentName,
            'nisn' => $student->nisn,
            'class' => $student->class,
            'gender' => $student->gender,
            'father_name' => $student->father_name,
            'mother_name' => $student->mother_name,
            'parents_address' => $student->parents_address ?? $student->address,
            'reason' => $request->reason,
            'duration' => $request->duration,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'teacher_name' => $teacher->user->name,
            'nip' => $teacher->nip,
            'letter_number' => $fullLetterNumber,
        ];

        $pdf = Pdf::loadView('gurubk.letters.skorsing_pdf', $data);
        
        $fileName = 'surat_skorsing_' . Str::slug($studentName) . '_' . time() . '.pdf';
        $filePath = 'letters/' . $fileName;
        
        \Illuminate\Support\Facades\Storage::disk('public')->put($filePath, $pdf->output());

        $letter = Letter::create([
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'type' => 'skorsing',
            'file_path' => $filePath,
            'content_json' => $data,
        ]);

        Archive::create([
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'guidance_notes' => 'Surat Pemberitahuan Skorsing: ' . $request->reason . ' (' . $request->duration . ' hari)',
            'completed_date' => now(),
            'attachment_path' => $filePath,
        ]);

        return redirect()->route('gurubk.archives.index', ['type' => 'surat'])
            ->with('success', 'Surat skorsing berhasil dibuat dan diarsipkan.')
            ->with('download_pdf_path', asset('storage/' . $filePath));
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
            'letter_number' => 'required|string|max:10',
            'reason' => 'required|string',
        ]);

        $teacher = Auth::user()->teacher;
        $student = Student::with('user')->findOrFail($request->student_id);

        if ($student->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to student.');
        }

        $studentName = $student->name ?? ($student->user ? $student->user->name : 'Tanpa Nama');

        $fullLetterNumber = '421.7 / ' . trim($request->letter_number) . ' / SMP.06 / ' . date('Y');

        $data = [
            'student_name' => $studentName,
            'nisn' => $student->nisn,
            'class' => $student->class,
            'gender' => $student->gender,
            'father_name' => $student->father_name,
            'mother_name' => $student->mother_name,
            'parents_address' => $student->parents_address ?? $student->address,
            'reason' => $request->reason,
            'teacher_name' => $teacher->user->name,
            'nip' => $teacher->nip,
            'letter_number' => $fullLetterNumber,
        ];

        $pdf = Pdf::loadView('gurubk.letters.sp1_pdf', $data);
        
        $fileName = 'surat_sp1_' . Str::slug($studentName) . '_' . time() . '.pdf';
        $filePath = 'letters/' . $fileName;
        
        \Illuminate\Support\Facades\Storage::disk('public')->put($filePath, $pdf->output());

        $letter = Letter::create([
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'type' => 'sp1',
            'file_path' => $filePath,
            'content_json' => $data,
        ]);

        Archive::create([
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'guidance_notes' => 'Surat Peringatan Pertama (SP1): ' . $request->reason,
            'completed_date' => now(),
            'attachment_path' => $filePath,
        ]);

        return redirect()->route('gurubk.archives.index', ['type' => 'surat'])
            ->with('success', 'Surat SP1 berhasil dibuat dan diarsipkan.')
            ->with('download_pdf_path', asset('storage/' . $filePath));
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
            'letter_number' => 'required|string|max:10',
            'reason' => 'required|string',
        ]);

        $teacher = Auth::user()->teacher;
        $student = Student::with('user')->findOrFail($request->student_id);

        if ($student->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to student.');
        }

        $studentName = $student->name ?? ($student->user ? $student->user->name : 'Tanpa Nama');

        $fullLetterNumber = '421.7 / ' . trim($request->letter_number) . ' / SMP.06 / ' . date('Y');

        $data = [
            'student_name' => $studentName,
            'nisn' => $student->nisn,
            'class' => $student->class,
            'gender' => $student->gender,
            'father_name' => $student->father_name,
            'mother_name' => $student->mother_name,
            'parents_address' => $student->parents_address ?? $student->address,
            'reason' => $request->reason,
            'teacher_name' => $teacher->user->name,
            'nip' => $teacher->nip,
            'letter_number' => $fullLetterNumber,
        ];

        $pdf = Pdf::loadView('gurubk.letters.sp2_pdf', $data);
        
        $fileName = 'surat_sp2_' . Str::slug($studentName) . '_' . time() . '.pdf';
        $filePath = 'letters/' . $fileName;
        
        \Illuminate\Support\Facades\Storage::disk('public')->put($filePath, $pdf->output());

        $letter = Letter::create([
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'type' => 'sp2',
            'file_path' => $filePath,
            'content_json' => $data,
        ]);

        Archive::create([
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'guidance_notes' => 'Surat Peringatan Kedua (SP2): ' . $request->reason,
            'completed_date' => now(),
            'attachment_path' => $filePath,
        ]);

        return redirect()->route('gurubk.archives.index', ['type' => 'surat'])
            ->with('success', 'Surat SP2 berhasil dibuat dan diarsipkan.')
            ->with('download_pdf_path', asset('storage/' . $filePath));
    }
}
