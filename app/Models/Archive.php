<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    protected $fillable = ['student_id', 'teacher_id', 'guidance_notes', 'completed_date', 'attachment_path'];

    protected function casts(): array
    {
        return [
            'completed_date' => 'date',
        ];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
