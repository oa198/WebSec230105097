<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GradesController extends Controller
{
    // إضافة middleware للتحقق من أن المستخدم مسجل دخوله
    public function __construct()
    {
        $this->middleware('auth');
    }

    // عرض الدرجات الخاصة بالمستخدم
    public function index()
    {
        $grades = Grade::where('user_id', auth()->id())->get();
        return view('exercises3.grades.index', compact('grades'));
    }

    // عرض صفحة إضافة درجة جديدة
    public function create()
    {
        $courses = Course::all();
        return view('exercises3.grades.create', compact('courses'));
    }

    // تخزين درجة جديدة في قاعدة البيانات
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'grade' => 'required|string',
            'term' => 'required|integer',
            'year' => 'required|integer',
        ]);

        Grade::create([
            'user_id' => auth()->user()->id,
            'course_id' => $request->course_id,
            'grade' => $request->grade,
            'term' => $request->term,
            'year' => $request->year,
        ]);

        return redirect()->route('exercises3.grades.index')->with('success', 'Grade added successfully.');
    }

    // عرض صفحة تعديل درجة
    public function edit(Grade $grade)
    {
        // التأكد أن الدرجة تخص المستخدم الحالي
        if ($grade->user_id != auth()->id()) {
            return redirect()->route('exercises3.grades.index')->with('error', 'Unauthorized access.');
        }

        $courses = Course::all();
        return view('exercises3.grades.edit', compact('grade', 'courses'));
    }

    // تحديث درجة في قاعدة البيانات
    public function update(Request $request, Grade $grade)
    {
        // التأكد أن الدرجة تخص المستخدم الحالي
        if ($grade->user_id != auth()->id()) {
            return redirect()->route('exercises3.grades.index')->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'grade' => 'required|string',
            'term' => 'required|integer',
            'year' => 'required|integer',
        ]);

        $grade->update([
            'course_id' => $request->course_id,
            'grade' => $request->grade,
            'term' => $request->term,
            'year' => $request->year,
        ]);

        return redirect()->route('exercises3.grades.index')->with('success', 'Grade updated successfully.');
    }

    // حذف درجة من قاعدة البيانات
    public function destroy(Grade $grade)
    {
        // التأكد أن الدرجة تخص المستخدم الحالي
        if ($grade->user_id != auth()->id()) {
            return redirect()->route('exercises3.grades.index')->with('error', 'Unauthorized access.');
        }

        $grade->delete();
        return redirect()->route('exercises3.grades.index')->with('success', 'Grade deleted successfully.');
    }
}
