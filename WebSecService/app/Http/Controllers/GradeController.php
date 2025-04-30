<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GradeController extends Controller
{
    public function index()
{
    $grades = Grade::with(['course', 'user']) 
        ->get()
        ->groupBy([
            'year',
            function ($item) {
                return $item->term;
            }
        ]);

    return view('exercises3.Grades.index', compact('grades'));
}

    public function create()
    {
        $courses = Course::all();
        return view('exercises3.Grades.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_code' => 'required|exists:courses,code',
            'grade' => 'required|string',
            'term' => 'required|integer',
            'year' => 'required|integer',
        ]);

        Grade::create([
            'user_id' => auth()->id(),
            'course_code' => $request->course_code,
            'grade' => $request->grade,
            'term' => $request->term,
            'year' => $request->year,
        ]);

        return redirect()->route('exercises3.Grades.index')->with('success', 'Grade added successfully.');
    }

    public function edit(Grade $grade)
    {
        if ($grade->user_id != auth()->id()) {
            return redirect()->route('exercises3.Grades.index')->with('error', 'Unauthorized access.');
        }

        $courses = Course::all();
        return view('exercises3.Grades.edit', compact('grade', 'courses'));
    }

    public function update(Request $request, Grade $grade)
    {
        if ($grade->user_id != auth()->id()) {
            return redirect()->route('exercises3.Grades.index')->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'course_code' => 'required|exists:courses,code',
            'grade' => 'required|string',
            'term' => 'required|integer',
            'year' => 'required|integer',
        ]);

        $grade->update([
            'course_code' => $request->course_code,
            'grade' => $request->grade,
            'term' => $request->term,
            'year' => $request->year,
        ]);

        return redirect()->route('exercises3.Grades.index')->with('success', 'Grade updated successfully.');
    }

    public function destroy(Grade $grade)
    {
        if ($grade->user_id != auth()->id()) {
            return redirect()->route('exercises3.Grades.index')->with('error', 'Unauthorized access.');
        }

        $grade->delete();
        return redirect()->route('exercises3.Grades.index')->with('success', 'Grade deleted successfully.');
    }
}
