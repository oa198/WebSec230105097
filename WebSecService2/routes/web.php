<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request; // Ensure the Request class is imported
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ProfileController;

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});

Auth::routes();
// Home Route
Route::get('/', function () {
    return view('welcome');
});

Route::resource('questions', QuestionController::class);


Route::resource('grades', GradeController::class);

Route::middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class)->except(['show']);
});

// MiniTest Route
Route::get('/MiniTest', function () {
    $bill = [
        ['item' => 'Orange', 'quantity' => 2, 'price' => 3.00],
        ['item' => 'Apple', 'quantity' => 1, 'price' => 4.50],
        ['item' => 'Water', 'quantity' => 3, 'price' => 2.00]
    ];
    return view('MiniTest', compact('bill'));
});

// Student Transcript Route
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

// Calculator Routes
Route::get('/calculator', function () {
    return view('calculator');
});

Route::post('/calculator', function (Request $request) {
    $request->validate([
        'num1' => 'required|numeric',
        'num2' => 'required|numeric',
        'operation' => 'required|in:+,-,*,/',
    ]);

    $num1 = $request->input('num1');
    $num2 = $request->input('num2');
    $operation = $request->input('operation');
    $result = match ($operation) {
        '+' => $num1 + $num2,
        '-' => $num1 - $num2,
        '*' => $num1 * $num2,
        '/' => ($num2 != 0) ? $num1 / $num2 : 'Error: Division by zero',
        default => 'Invalid Operation'
    };

    return view('calculator', compact('result'));
});

// Product Routes
Route::resource('products', ProductController::class);

// Protected User Routes (Require Authentication)



