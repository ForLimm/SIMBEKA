<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Shared password validation rules for SIMBEKA.
 * 
 * Used as a trait-like class — call PasswordRules::rules() and PasswordRules::messages()
 * to get the standard password validation array. This eliminates 5+ copies of the same rules.
 */
class PasswordRules
{
    /**
     * Get the password validation rules.
     *
     * @param  string  $fieldName  The form field name (e.g., 'password', 'new_password')
     * @param  bool    $required   Whether the field is required (false for update forms)
     * @param  bool    $confirmed  Whether the field requires confirmation
     */
    public static function rules(string $fieldName = 'password', bool $required = true, bool $confirmed = true): array
    {
        $rules = [
            'min:8',
            'regex:/[a-z]/',      // must contain at least one lowercase letter
            'regex:/[A-Z]/',      // must contain at least one uppercase letter
            'regex:/[0-9]/',      // must contain at least one digit
            'regex:/[@$!%*?&]/',  // must contain at least one special character
        ];

        if ($required) {
            array_unshift($rules, 'required');
        } else {
            array_unshift($rules, 'nullable');
        }

        if ($confirmed) {
            $rules[] = 'confirmed';
        }

        return [$fieldName => $rules];
    }

    /**
     * Get the password validation messages.
     *
     * @param  string  $fieldName  The form field name
     */
    public static function messages(string $fieldName = 'password'): array
    {
        return [
            "{$fieldName}.required" => 'Kolom Password wajib diisi.',
            "{$fieldName}.min" => 'Password minimal harus 8 karakter.',
            "{$fieldName}.regex" => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter khusus (@$!%*?&).',
            "{$fieldName}.confirmed" => 'Konfirmasi password tidak cocok.',
        ];
    }
}
