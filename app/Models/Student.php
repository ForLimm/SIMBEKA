<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 
        'teacher_id', 
        'name', 
        'nisn', 
        'photo',
        'class',
        'birth_place', 
        'birth_date', 
        'gender', 
        'religion', 
        'address', 
        'phone',
        'father_name', 
        'mother_name', 
        'parents_job', 
        'parents_phone', 
        'parents_address', 
        'living_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'reported_by', 'user_id');
    }

    public function archives()
    {
        return $this->hasMany(Archive::class);
    }

    public function letters()
    {
        return $this->hasMany(Letter::class)->latest();
    }

    public function counselingSessions()
    {
        return $this->hasMany(CounselingSession::class)->latest('counseling_date');
    }

    /**
     * Mutator to automatically normalize the class name when setting it.
     */
    public function setClassAttribute($value)
    {
        $this->attributes['class'] = self::normalizeClass($value);
    }

    /**
     * Standardize any class name format into the consistent format.
     */
    public static function normalizeClass($class)
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

        return $class;
    }
}
