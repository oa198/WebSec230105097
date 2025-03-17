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
            'course' => 'Web Security', // تأكد من وضع قيمة للعمود course
        ]);

        Grade::create([
            'student_name' => 'Jane Smith',
            'grade' => 'B',
            'course' => 'Cybersecurity', // أضف قيمة هنا أيضًا
        ]);
    }
}

