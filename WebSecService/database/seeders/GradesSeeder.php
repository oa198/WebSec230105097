<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grade;

class GradesSeeder extends Seeder
{
    public function run()
    {
        Grade::create([
            'student_name' => 'John Doe',
            'grade' => 'A',
            'course' => 'Web Security', 
        ]);

        Grade::create([
            'student_name' => 'Jane Smith',
            'grade' => 'B',
            'course' => 'Cybersecurity',
        ]);
    }
}

