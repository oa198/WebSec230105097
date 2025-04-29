<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    // عرض قائمة الكورسات
    public function index()
    {
        $courses = Course::all();
        return view('exercises3.courses.index', compact('courses'));
    }

    // عرض صفحة إضافة كورس جديد
    public function create()
    {
        return view('exercises3.courses.create');
    }

    // تخزين كورس جديد في قاعدة البيانات
    public function store(Request $request)
    {
        $request->validate([
            'course_code' => 'required|unique:courses,course_code',
            'course_name' => 'required|string|max:100',
            'credit_hours' => 'required|integer|min:1',
        ]);

        Course::create($request->all());

        return redirect()->route('exercises3.courses.index')->with('success', 'Course added successfully.');
    }

    // عرض صفحة تعديل كورس
    public function edit(Course $course)
    {
        return view('exercises3.courses.edit', compact('course'));
    }

    // تحديث كورس في قاعدة البيانات
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'course_code' => 'required|unique:courses,course_code,' . $course->id,
            'course_name' => 'required|string|max:100',
            'credit_hours' => 'required|integer|min:1',
        ]);

        $course->update($request->all());

        return redirect()->route('exercises3.courses.index')->with('success', 'Course updated successfully.');
    }

    // حذف كورس من قاعدة البيانات
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('exercises3.courses.index')->with('success', 'Course deleted successfully.');
    }
}
