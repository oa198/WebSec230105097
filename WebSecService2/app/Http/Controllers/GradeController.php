<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller {
    // Display the list of grades
    public function index() {
        $terms = Grade::select('term')->distinct()->get();
        $gradesByTerm = [];

        foreach ($terms as $term) {
            $grades = Grade::where('term', $term->term)->get();

            // حساب إجمالي الساعات المعتمدة للفصل الدراسي
            $totalCreditHours = $grades->sum('credit_hours');

            // حساب النقاط لكل مادة
            $totalGradePoints = $grades->sum(function ($grade) {
                return $this->getGradePoints($grade->grade) * $grade->credit_hours;
            });

            // حساب الـ GPA
            $gpa = $totalCreditHours > 0 ? $totalGradePoints / $totalCreditHours : 0;

            $gradesByTerm[$term->term] = [
                'grades' => $grades,
                'totalCreditHours' => $totalCreditHours,
                'gpa' => number_format($gpa, 2),
            ];
        }

        // حساب CGPA و CCH العام
        $allGrades = Grade::all();
        $cch = $allGrades->sum('credit_hours');
        $totalGradePoints = $allGrades->sum(function ($grade) {
            return $this->getGradePoints($grade->grade) * $grade->credit_hours;
        });

        $cgpa = $cch > 0 ? $totalGradePoints / $cch : 0;

        return view('grades.index', compact('gradesByTerm', 'cgpa', 'cch'));
    }

    // تحويل الحروف إلى نقاط GPA
    private function getGradePoints($grade) {
        $points = [
            'A' => 4.0,
            'B' => 3.0,
            'C' => 2.0,
            'D' => 1.0,
            'F' => 0.0,
        ];
        return $points[$grade] ?? 0.0;
    }


    // Show form for creating a new grade
    public function create() {
        return view('grades.create');
    }

    // Store a new grade
    public function store(Request $request) {
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'score' => 'required|integer|min:0|max:100',
            'term' => 'required|string|max:255',
            'credit_hours' => 'required|integer|min:1',
        ]);

        $gradeValue = $this->calculateGrade($validated['score']);

        Grade::create([
            'student_name' => $validated['student_name'],
            'subject' => $validated['subject'],
            'score' => $validated['score'],
            'grade' => $gradeValue,
            'term' => $validated['term'],
            'credit_hours' => $validated['credit_hours'],
        ]);

        return redirect()->route('grades.index')->with('success', 'Grade added successfully!');
    }


    // Show form for editing an existing grade
    public function edit(Grade $grade) {
        return view('grades.edit', compact('grade'));
    }

    // Update an existing grade
    public function update(Request $request, Grade $grade) {
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'score' => 'required|integer|min:0|max:100',
            'term' => 'required|string|max:255',
            'credit_hours' => 'required|integer|min:1',
        ]);

        // Recalculate the grade letter
        $gradeValue = $this->calculateGrade($validated['score']);

        $grade->update([
            'student_name' => $validated['student_name'],
            'subject' => $validated['subject'],
            'score' => $validated['score'],
            'grade' => $gradeValue,
            'term' => $validated['term'],
            'credit_hours' => $validated['credit_hours'],
        ]);

        return redirect()->route('grades.index')->with('success', 'Grade updated successfully!');
    }


    // Delete a grade
    public function destroy(Grade $grade) {
        $grade->delete();
        return redirect()->route('grades.index')->with('success', 'Grade deleted successfully!');
    }

    // Calculate letter grade based on score
    private function calculateGrade($score) {
        if ($score >= 90) return 'A';
        if ($score >= 80) return 'B';
        if ($score >= 70) return 'C';
        if ($score >= 60) return 'D';
        return 'F';
    }
}
