<?php

namespace App\Http\Controllers;

use App\Models\Grade;

// Ensure the Grade model exists in the App\Models namespace
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::orderBy('year', 'desc')
                 ->orderBy('term', 'desc')
                 ->get()
                 ->groupBy(['year', 'term']);

        return view('exercises3.Grades.index', compact('grades'));
    }

    public function create()
    {
        return view('exercises3.Grades.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_code' => 'required|string|max:10',
            'course_name' => 'required|string|max:100',
            'credit_hours' => 'required|integer|min:1|max:5',
            'grade' => 'required|string|in:A+,A,A-,B+,B,B-,C+,C,C-,D+,D,F',
            'term' => 'required|integer|min:1|max:3',
            'year' => 'required|integer|min:2000|max:2099'
        ]);


        $validated['user_id'] = $request->input('user_id', 2);
        Grade::create($validated);

        return redirect()->route('exercises3.Grades.index')
               ->with('success', 'Grade added successfully');
    }

    public function edit(Grade $grade)
    {
        return view('exercises3.Grades.edit', compact('grade'));
    }

    public function update(Request $request, Grade $grade)
    {
        $validated = $request->validate([
            'course_code' => 'required|string|max:10',
            'course_name' => 'required|string|max:100',
            'credit_hours' => 'required|integer|min:1|max:5',
            'grade' => 'required|string|in:A+,A,A-,B+,B,B-,C+,C,C-,D+,D,F',
            'term' => 'required|integer|min:1|max:3',
            'year' => 'required|integer|min:2000|max:2099'
        ]);

        $grade->update($validated);

        return redirect()->route('exercises3.Grades.index')
               ->with('success', 'Grade updated successfully');
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();
        return redirect()->route('exercises3.Grades.index')
               ->with('success', 'Grade deleted successfully');
    }
}
