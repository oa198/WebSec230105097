<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    // حماية جميع الوظائف بميدلوير auth
   
    // عرض جميع الأسئلة
    public function index()
    {
        $questions = Question::latest()->paginate(10); // إضافة Pagination لعرض 10 أسئلة فقط في الصفحة
        return view('questions.index', compact('questions'));
    }

    // عرض نموذج إضافة سؤال جديد
    public function create()
    {
        return view('questions.create');
    }

    // تخزين سؤال جديد
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'question' => 'required|string|max:500',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'option_d' => 'required|string|max:255',
            'correct_answer' => 'required|string|in:option_a,option_b,option_c,option_d',
        ]);

        Question::create([
            'question' => $validatedData['question'],
            'option_a' => $validatedData['option_a'],
            'option_b' => $validatedData['option_b'],
            'option_c' => $validatedData['option_c'],
            'option_d' => $validatedData['option_d'],
            'correct_answer' => $validatedData['correct_answer'],
        ]);

        return redirect()->route('questions.index')->with('success', 'MCQ Created Successfully!');
    }
}
