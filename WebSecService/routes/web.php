<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\QuestionController;



Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/profile', function () {
    return view('profile');
})->middleware('auth');


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class);
});
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');


Route::resource('questions', QuestionController::class);

Route::get('/MiniTest', function () {
    $bill = [
        ['item' => 'Orange', 'quantity' => 2, 'price' => 3.00],
        ['item' => 'Apple', 'quantity' => 1, 'price' => 4.50],
        ['item' => 'Water', 'quantity' => 3, 'price' => 2.00]
    ];

    return view('MiniTest', ['bill' => $bill]);
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

    return view('Transcript', compact('student', 'finalGPA'));
});

Route::get('/products', function () {
    $products = [
        ['name' => 'Laptop', 'image' => 'laptop.jpg', 'price' => 999.99, 'description' => 'Powerful gaming laptop.'],
        ['name' => 'Smartphone', 'image' => 'phone.jpg', 'price' => 499.99, 'description' => 'Latest smartphone with AI camera.'],
        ['name' => 'Headphones', 'image' => 'headphones.jpg', 'price' => 99.99, 'description' => 'Noise-canceling headphones.'],
    ];
    return view('products', compact('products'));
});

Route::get('/calculator', function () {
    return view('calculator');
});

Route::resource('grades', GradeController::class);

Route::get('/grades', function () {
    return view('grades.index');
});

Route::get('/grades', [GradeController::class, 'index'])->name('grades.index');
Route::get('/grades/create', [GradeController::class, 'create'])->name('grades.create');
Route::post('/grades', [GradeController::class, 'store'])->name('grades.store');
