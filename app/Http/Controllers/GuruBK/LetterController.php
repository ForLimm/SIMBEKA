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
    public function create()
    {
        $teacher = Auth::user()->teacher;
        $students = Student::with('user')->where('teacher_id', $teacher->id)->get();
        return view('gurubk.letters.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'time' => 'nullable|string',
            'reason' => 'required|string',
        ]);

        $teacher = Auth::user()->teacher;
        $student = Student::with('user')->findOrFail($request->student_id);

        if ($student->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized access to student.');
        }

        // Safe name resolution
        $studentName = $student->name ?? ($student->user ? $student->user->name : 'Tanpa Nama');

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

        return redirect()->route('gurubk.archives.index')->with('success', 'Surat panggilan berhasil dibuat dan diarsipkan.');
    }
}
