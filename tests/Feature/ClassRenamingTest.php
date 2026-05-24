<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Student;

class ClassRenamingTest extends TestCase
{
    /** @test */
    public function it_normalizes_class_names_automatically()
    {
        $this->assertEquals('7 andalan', Student::normalizeClass('VII-A'));
        $this->assertEquals('7 andalan', Student::normalizeClass('VII-1'));
        $this->assertEquals('7 andalan', Student::normalizeClass('7A'));
        $this->assertEquals('7 andalan', Student::normalizeClass('7 A'));
        $this->assertEquals('7 andalan', Student::normalizeClass('7 andalan'));
        $this->assertEquals('9 tut wuri handayani', Student::normalizeClass('IX-3'));
        $this->assertEquals('8 budi pekerti', Student::normalizeClass('VIII-B'));
        $this->assertEquals('8 budi pekerti', Student::normalizeClass('VIII-2'));
        $this->assertEquals('8 harmonis', Student::normalizeClass('VIII-8'));
    }
}
