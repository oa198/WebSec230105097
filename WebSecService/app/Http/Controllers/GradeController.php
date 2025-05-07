<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::with(['user:id,name', 'course:id,code,name,credit_hours'])
                    ->get()
                    ->groupBy(['year', 'term']);

        return view('exercises3.grades.index', compact('grades'));
    }


    public function create()
    {
        $users = User::all(['id', 'name']);
        $courses = Course::all(['code', 'name', 'credit_hours']);

        return view('exercises3.grades.create', compact('users', 'courses'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'course_code' => 'required|exists:courses,code',
        'grade' => 'required|in:A+,A,A-,B+,B,B-,C+,C,C-,D+,D,F',
        'term' => 'required|integer|min:1|max:3',
        'year' => 'required|integer|min:2000|max:2099',
        'user_id' => 'required|exists:users,id'
    ]);

    $course = Course::where('code', $validated['course_code'])->first();

    $grade = Grade::create([
        'user_id' => $validated['user_id'],
        'course_id' => $course->id, // ✅ أصل العلاقة الصحيح
        'grade' => $validated['grade'],
        'term' => $validated['term'],
        'year' => $validated['year'],
    ]);

    return redirect()->route('exercises3.Grades.index')
                     ->with('success', 'Grade added successfully');
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
       
        $grade->delete();
        return redirect()->route('exercises3.Grades.index')->with('success', 'Grade deleted successfully.');
    }
}
