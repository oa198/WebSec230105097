<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    // Display the list of all courses
    public function index()
    {
        $courses = Course::all();
        return view('exercises3.courses.index', compact('courses'));
    }

    // Show the form to create a new course
    public function create()
    {
        return view('exercises3.courses.create');
    }

    // Store a newly created course in the database
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:courses,code',
            'name' => 'required|string|max:100',
            'credit_hours' => 'required|integer|min:1',
            'description' => 'nullable|string|max:500',
        ]);

        Course::create([
            'code' => $request->code,
            'name' => $request->name,
            'credit_hours' => $request->credit_hours,
            'description' => $request->description,
        ]);

        return redirect()->route('exercises3.courses.index')
                         ->with('success', 'Course added successfully.');
    }

    // Show details of a specific course
    public function show(Course $course)
    {
        return view('exercises3.courses.show', compact('course'));
    }

    // Show the form for editing the specified course
    public function edit(Course $course)
    {
        return view('exercises3.courses.edit', compact('course'));
    }

    // Update the specified course in the database
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'code' => 'required|unique:courses,code,' . $course->id,
            'name' => 'required|string|max:100',
            'credit_hours' => 'required|integer|min:1',
            'description' => 'nullable|string|max:500',
        ]);

        $course->update([
            'code' => $request->code,
            'name' => $request->name,
            'credit_hours' => $request->credit_hours,
            'description' => $request->description,
        ]);

        return redirect()->route('exercises3.courses.index')
                         ->with('success', 'Course updated successfully.');
    }

    // Delete the specified course from the database
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('exercises3.courses.index')
                         ->with('success', 'Course deleted successfully.');
    }
}
