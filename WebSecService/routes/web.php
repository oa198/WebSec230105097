<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\GradeController;
use Illuminate\Support\Facades\Auth;


Auth::routes();

Route::get('/home', function () {
    return view('Home');
})->name('home');

Route::get('/users', [UserController::class, 'index'])->name('exercises3.Users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('exercises3.Users.create');
Route::post('/users', [UserController::class, 'store'])->name('exercises3.Users.store');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('exercises3.Users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('exercises3.Users.update');
// Use a distinct URI for profile to avoid conflict
Route::get('/users/{user}/profile', [UserController::class, 'profile'])->name('exercises3.Users.profile');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('exercises3.Users.destroy');
// Now this route can work without conflict
Route::get('/users/{user}', [UserController::class, 'show'])->name('exercises3.Users.show');


Route::get('/grades', [GradeController::class, 'index'])->name('exercises3.Grades.index');
Route::get('/grades/create', [GradeController::class, 'create'])->name('exercises3.Grades.create');
Route::post('/grades', [GradeController::class, 'store'])->name('exercises3.Grades.store');
Route::get('/grades/{grade}/edit', [GradeController::class, 'edit'])->name('exercises3.Grades.edit');
Route::put('/grades/{grade}', [GradeController::class, 'update'])->name('exercises3.Grades.update');
Route::delete('/grades/{grade}', [GradeController::class, 'destroy'])->name('exercises3.Grades.destroy');
Route::get('/grades/{grade}', [GradeController::class, 'show'])->name('exercises3.Grades.show');

// Rest of your routes remain unchanged
Route::get('/multable', function (Request $request) {
    $j = $request->number ?? 5;
    $msg = $request->msg;
    return view('Multable', compact("j", "msg"));
});

Route::get('/even', function () {
    return view('Even');
});

Route::get('/prime', function () {
    return view('Prime');
});

Route::get('/minitest', function () {
    $marks = [
        ['item' => 'Orange', 'quantity' => 2, 'price' => 3.00],
        ['item' => 'Apple', 'quantity' => 1, 'price' => 4.50],
        ['item' => 'Water', 'quantity' => 3, 'price' => 2.00]
    ];
    return view('Exercises2.minitest', compact('marks'));
});

Route::get('/Transcript', function () {
    $student = [
        'name' => 'Omar Ahmed',
        'id' => '230102345',
        'department' => 'Cybersecurity',
        'courses' => [
            ['name' => 'Web Security', 'credit_hours' => 3, 'gpa' => 3.8, 'grade' => 'A'],
            ['name' => 'Computer Networks', 'credit_hours' => 4, 'gpa' => 3.5, 'grade' => 'B+'],
            ['name' => 'Database Systems', 'credit_hours' => 3, 'gpa' => 3.7, 'grade' => 'A-'],
        ]
    ];

    $totalPoints = collect($student['courses'])->sum(fn($course) => $course['credit_hours'] * $course['gpa']);
    $totalCredits = collect($student['courses'])->sum('credit_hours');
    $finalGPA = $totalCredits > 0 ? number_format($totalPoints / $totalCredits, 2) : 0;

    return view('exercises2.Transcript', compact('student', 'finalGPA'));
});

Route::get('/products', function () {
    $products = [
        [
            'id' => 1,
            'name' => 'Wireless Headphones',
            'price' => 99.99,
            'description' => 'Premium noise-cancelling wireless headphones with 30hr battery life.'
        ],
        [
            'id' => 2,
            'name' => 'Smart Watch',
            'price' => 199.99,
            'description' => 'Fitness tracker with heart rate monitor and GPS.'
        ],
        [
            'id' => 3,
            'name' => 'Bluetooth Speaker',
            'price' => 59.99,
            'description' => 'Portable waterproof speaker with 20hr playtime.'
        ],
        [
            'id' => 4,
            'name' => 'Phone Charger',
            'price' => 19.99,
            'description' => 'Fast-charging USB-C cable with adapter.'
        ]
    ];
    return view('exercises2.products', compact('products'));
});

Route::get('/calculator', function () {
    return view('exercises2.calculator');
});

Route::get('/calculatorGPA', function () {
    $courses = [
        ['code' => 'CS101', 'title' => 'Introduction to Programming', 'credits' => 3],
        ['code' => 'MATH201', 'title' => 'Calculus I', 'credits' => 4],
        ['code' => 'ENG102', 'title' => 'Academic Writing', 'credits' => 2],
        ['code' => 'PHYS101', 'title' => 'General Physics', 'credits' => 4],
        ['code' => 'CHEM101', 'title' => 'General Chemistry', 'credits' => 4]
    ];
    return view('exercises2.calculatorGPA', compact('courses'));
});

Route::get('/test', function () {
    return view('test');
});


