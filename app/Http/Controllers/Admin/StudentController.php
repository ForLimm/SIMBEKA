<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Http\Requests\StudentRules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with(['user', 'teacher.user']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('class')) {
            $query->where('class', $request->class);
        }

        if ($request->filled('teacher_id')) {
            if ($request->teacher_id === 'unassigned') {
                $query->whereNull('teacher_id');
            } else {
                $query->where('teacher_id', $request->teacher_id);
            }
        }

        $students = $query->latest()->paginate(15)->withQueryString();
        $teachers = Teacher::with('user')->get();
        $classes = Student::whereNotNull('class')->distinct()->orderBy('class')->pluck('class');

        return view('admin.students.index', compact('students', 'teachers', 'classes'));
    }

    public function create()
    {
        $teachers = Teacher::with('user')->get();
        return view('admin.students.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $request->validate(array_merge(StudentRules::storeRules(), [
            'teacher_id' => 'nullable|exists:teachers,id',
        ]), StudentRules::messages());

        $data = $request->only(StudentRules::safeFields());
        $data['user_id'] = null;
        $data['teacher_id'] = $request->teacher_id;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('student-photos', 'public');
        }

        Student::create($data);

        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function edit(Student $student)
    {
        $student->load('user');
        $teachers = Teacher::with('user')->get();
        return view('admin.students.edit', compact('student', 'teachers'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate(array_merge(StudentRules::updateRules($student->id), [
            'teacher_id' => 'nullable|exists:teachers,id',
        ]), StudentRules::messages());

        $data = $request->only(StudentRules::safeFields());
        $data['teacher_id'] = $request->teacher_id;

        // Handle photo removal
        if ($request->has('remove_photo') && $request->remove_photo == '1') {
            if ($student->photo && file_exists(public_path('storage/' . $student->photo))) {
                @unlink(public_path('storage/' . $student->photo));
            }
            $data['photo'] = null;
        }

        // Handle new photo upload
        if ($request->hasFile('photo')) {
            if ($student->photo && file_exists(public_path('storage/' . $student->photo))) {
                @unlink(public_path('storage/' . $student->photo));
            }
            $data['photo'] = $request->file('photo')->store('student-photos', 'public');
        }

        $student->update($data);

        $user = $student->user;
        if ($user) {
            $user->update([
                'name' => $request->name,
            ]);
        }

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        if ($student->user) {
            $student->user->delete();
        }
        $student->delete();

        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil dihapus.');
    }

    public function import(Request $request)
    {
        @set_time_limit(180);
        DB::disableQueryLog();

        $request->validate([
            'file' => 'required|file|max:10240',
        ], [
            'file.required' => 'Berkas Excel wajib diunggah.',
        ]);

        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, ['xlsx', 'xls', 'csv'])) {
            return back()->with('error', 'Format berkas harus berupa Excel (.xlsx, .xls) atau CSV.');
        }

        $path = $file->getRealPath();

        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membaca berkas Excel: ' . $e->getMessage());
        }

        $headers = array_shift($rows);
        if (!$headers) {
            return back()->with('error', 'Format berkas tidak valid atau kosong.');
        }

        // Clean and prepare header mapping
        $columnMapping = [
            'name' => ['nama lengkap siswa', 'nama lengkap', 'nama siswa', 'nama', 'name'],
            'nisn' => ['nisn', 'nomor induk siswa nasional', 'no induk siswa nasional'],
            'class' => ['kelas', 'class'],
            'gender' => ['jenis kelamin', 'jenis_kelamin', 'jk', 'kelamin', 'gender'],
            'religion' => ['agama', 'religion'],
            'birth_place' => ['tempat lahir', 'tempat_lahir', 'birth_place', 'tempat lahir siswa'],
            'birth_date' => ['tanggal lahir', 'tanggal_lahir', 'tgl lahir', 'birth_date', 'tanggal lahir siswa'],
            'living_status' => ['status tinggal', 'status_tinggal', 'living_status', 'status tinggal siswa'],
            'address' => ['alamat lengkap', 'alamat', 'alamat siswa', 'address'],
            'phone' => ['no. hp siswa', 'no hp siswa', 'no hp', 'nomor hp', 'telepon', 'phone'],
            'father_name' => ['nama ayah', 'ayah', 'father_name'],
            'mother_name' => ['nama ibu', 'ibu', 'mother_name'],
        ];

        $mappedHeaders = [];
        foreach ($headers as $index => $rawHeader) {
            if ($rawHeader === null) {
                $mappedHeaders[$index] = null;
                continue;
            }
            $header = strtolower(trim($rawHeader));
            $foundKey = null;
            foreach ($columnMapping as $dbKey => $synonyms) {
                if (in_array($header, $synonyms)) {
                    $foundKey = $dbKey;
                    break;
                }
            }
            // If no exact match, try matching via substring
            if (!$foundKey) {
                foreach ($columnMapping as $dbKey => $synonyms) {
                    foreach ($synonyms as $synonym) {
                        if (str_contains($header, $synonym) || str_contains($synonym, $header)) {
                            $foundKey = $dbKey;
                            break 2;
                        }
                    }
                }
            }
            $mappedHeaders[$index] = $foundKey;
        }

        $rowCount = 0;
        $successCount = 0;
        $updatedCount = 0;
        $duplicateCount = 0;
        $formatErrors = [];

        foreach ($rows as $row) {
            $rowCount++;
            // Skip empty rows
            if (empty(array_filter($row))) {
                continue;
            }

            $data = [];
            foreach ($row as $index => $value) {
                $dbKey = $mappedHeaders[$index] ?? null;
                if ($dbKey) {
                    $data[$dbKey] = $value !== null ? trim($value) : null;
                }
            }

            $name = $data['name'] ?? null;
            $nisn = $data['nisn'] ?? null;

            if (!$name || !$nisn) {
                $formatErrors[] = "Baris #{$rowCount}: Kolom Nama dan NISN wajib diisi.";
                continue;
            }

            // NISN validation length check
            if (strlen($nisn) !== 10 || !is_numeric($nisn)) {
                $formatErrors[] = "Baris #{$rowCount}: NISN '{$nisn}' tidak valid (harus 10 digit angka).";
                continue;
            }

            // Check if Student already exists by NISN
            $student = Student::where('nisn', $nisn)->first();

            if ($student) {
                $user = $student->user;
                $parsedBirthDate = $this->parseDate($data['birth_date'] ?? null);

                // Determine if anything changed
                $hasChanges = false;
                if ($user && $user->name !== $name) {
                    $hasChanges = true;
                }

                $fieldsToCompare = [
                    'name' => $name,
                    'class' => $data['class'] ?? null,
                    'gender' => $data['gender'] ?? null,
                    'religion' => $data['religion'] ?? null,
                    'birth_place' => $data['birth_place'] ?? null,
                    'birth_date' => $parsedBirthDate,
                    'living_status' => $data['living_status'] ?? null,
                    'address' => $data['address'] ?? null,
                    'phone' => $data['phone'] ?? null,
                    'father_name' => $data['father_name'] ?? null,
                    'mother_name' => $data['mother_name'] ?? null,
                ];

                foreach ($fieldsToCompare as $key => $val) {
                    $oldVal = $student->$key;
                    $oldTrimmed = $oldVal !== null ? trim($oldVal) : null;
                    $newTrimmed = $val !== null ? trim($val) : null;
                    if ($oldTrimmed !== $newTrimmed) {
                        $hasChanges = true;
                        break;
                    }
                }

                if ($hasChanges) {
                    if ($user) {
                        $user->update(['name' => $name]);
                    }
                    $student->update([
                        'name' => $name,
                        'class' => $data['class'] ?? null,
                        'gender' => $data['gender'] ?? null,
                        'religion' => $data['religion'] ?? null,
                        'birth_place' => $data['birth_place'] ?? null,
                        'birth_date' => $parsedBirthDate,
                        'living_status' => $data['living_status'] ?? null,
                        'address' => $data['address'] ?? null,
                        'phone' => $data['phone'] ?? null,
                        'father_name' => $data['father_name'] ?? null,
                        'mother_name' => $data['mother_name'] ?? null,
                    ]);
                    $updatedCount++;
                } else {
                    $duplicateCount++;
                }
                continue;
            }

            // Create new Student without User account
            Student::create([
                'user_id' => null,
                'name' => $name,
                'nisn' => $nisn,
                'class' => $data['class'] ?? null,
                'gender' => $data['gender'] ?? null,
                'religion' => $data['religion'] ?? null,
                'birth_place' => $data['birth_place'] ?? null,
                'birth_date' => $this->parseDate($data['birth_date'] ?? null),
                'living_status' => $data['living_status'] ?? null,
                'address' => $data['address'] ?? null,
                'phone' => $data['phone'] ?? null,
                'father_name' => $data['father_name'] ?? null,
                'mother_name' => $data['mother_name'] ?? null,
            ]);

            $successCount++;
        }

        $errors = [];

        // Scenario 1: All rows are duplicates (no new inserts, no updates, duplicates > 0, no format errors)
        if ($successCount === 0 && $updatedCount === 0 && $duplicateCount > 0 && empty($formatErrors)) {
            return redirect()->route('admin.students.index')
                ->with('error', 'Semua data siswa dalam berkas sudah terdaftar dan tidak ada perubahan data.');
        }

        // Scenario 2: Some rows imported or updated successfully
        if ($successCount > 0 || $updatedCount > 0) {
            $msgParts = [];
            if ($successCount > 0) {
                $msgParts[] = "mengimpor {$successCount} siswa baru";
            }
            if ($updatedCount > 0) {
                $msgParts[] = "memperbarui {$updatedCount} data siswa";
            }
            $msg = "Berhasil " . implode(" dan ", $msgParts) . ".";

            if ($duplicateCount > 0) {
                $errors[] = "Sebanyak {$duplicateCount} data siswa dilewati karena sudah terdaftar dan datanya sama.";
            }
            $errors = array_merge($errors, $formatErrors);

            if (count($errors) > 0) {
                return redirect()->route('admin.students.index')
                    ->with('success', $msg)
                    ->withErrors($errors);
            }
            return redirect()->route('admin.students.index')->with('success', $msg);
        }

        // Scenario 3: No success, no updates, but we have errors (format errors / duplicates)
        if ($duplicateCount > 0) {
            $errors[] = "Sebanyak {$duplicateCount} data siswa dilewati karena sudah terdaftar dan datanya sama.";
        }
        $errors = array_merge($errors, $formatErrors);

        return redirect()->route('admin.students.index')->withErrors($errors);
    }

    private function parseDate($value)
    {
        if (empty($value)) {
            return null;
        }

        if (is_numeric($value)) {
            try {
                return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value))->format('Y-m-d');
            } catch (\Exception $e) {
                // Silently fallback if it's not a numeric Excel timestamp
            }
        }

        $value = trim($value);

        $formats = ['d/m/Y', 'Y-m-d', 'd-m-Y', 'm/d/Y', 'Y/m/d', 'd.m.Y', 'Y.m.d'];
        foreach ($formats as $format) {
            try {
                $d = \Carbon\Carbon::createFromFormat($format, $value);
                if ($d) {
                    return $d->format('Y-m-d');
                }
            } catch (\Exception $e) {
                // Try next format
            }
        }

        try {
            return \Carbon\Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
