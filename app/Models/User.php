<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'username', 'email', 'password', 'role', 'is_guest', 'recovery_code', 'security_question', 'security_answer'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    public function getRecoveryCodeDecryptAttribute()
    {
        if (empty($this->recovery_code)) {
            return null;
        }

        try {
            return \Illuminate\Support\Facades\Crypt::decryptString($this->recovery_code);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return $this->recovery_code;
        }
    }
    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'reported_by');
    }

    public function handledReports()
    {
        return $this->hasMany(Report::class, 'handled_by');
    }
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
