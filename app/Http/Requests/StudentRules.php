<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Shared student validation rules for store & update operations.
 * Used by both GuruBK\StudentController and Admin\StudentController.
 */
class StudentRules
{
    /**
     * Common student fields with validation rules.
     */
    private static array $baseFields = [
        'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s.,\']+$/'],
        'class' => 'required|string',
        'gender' => 'required|string|in:Laki-laki,Perempuan',
        'religion' => 'nullable|string|in:Islam,Kristen,Katolik,Hindu,Buddha,Khonghucu',
        'birth_place' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z\s.,\']+$/'],
        'birth_date' => 'nullable|date|before:today',
        'living_status' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:1000',
        'phone' => 'nullable|string|digits_between:10,15',
        'father_name' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z\s.,\']+$/'],
        'mother_name' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z\s.,\']+$/'],
        'parents_job' => 'nullable|string|max:255',
        'parents_phone' => 'nullable|string|digits_between:10,15',
        'parents_address' => 'nullable|string|max:1000',
    ];

    /**
     * Get validation rules for creating a new student.
     */
    public static function storeRules(): array
    {
        return array_merge(self::$baseFields, [
            'nisn' => 'required|string|digits:10|unique:students,nisn',
        ]);
    }

    /**
     * Get validation rules for updating an existing student.
     *
     * @param int $studentId  The student ID to exclude from unique check
     */
    public static function updateRules(int $studentId): array
    {
        return array_merge(self::$baseFields, [
            'nisn' => 'required|string|digits:10|unique:students,nisn,' . $studentId,
        ]);
    }

    /**
     * Get custom validation messages (shared between store and update).
     */
    public static function messages(): array
    {
        return [
            'name.regex' => 'Nama siswa hanya boleh berisi huruf, spasi, titik, koma, atau tanda kutip.',
            'nisn.digits' => 'NISN harus berupa 10 digit angka.',
            'phone.digits_between' => 'Nomor HP siswa harus berupa angka antara 10 sampai 15 digit.',
            'father_name.regex' => 'Nama ayah hanya boleh berisi huruf, spasi, titik, koma, atau tanda kutip.',
            'mother_name.regex' => 'Nama ibu hanya boleh berisi huruf, spasi, titik, koma, atau tanda kutip.',
            'parents_phone.digits_between' => 'Nomor HP orang tua harus berupa angka antara 10 sampai 15 digit.',
            'birth_place.regex' => 'Tempat lahir hanya boleh berisi huruf dan spasi.',
            'birth_date.before' => 'Tanggal lahir harus sebelum hari ini.',
        ];
    }

    /**
     * Get the safe field names for $request->only().
     */
    public static function safeFields(): array
    {
        return [
            'name', 'nisn', 'class', 'gender', 'religion', 'birth_place', 'birth_date',
            'living_status', 'address', 'phone', 'father_name', 'mother_name',
            'parents_job', 'parents_phone', 'parents_address',
        ];
    }
}
