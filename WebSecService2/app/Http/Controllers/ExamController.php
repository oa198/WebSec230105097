<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class ExamController extends Controller {
    // Show the exam page
    public function startExam() {
        $questions = Question::all();
        return view('exam.start', compact('questions'));
    }

    // Process the exam submission
    public function submitExam(Request $request) {
        $score = 0;
        $totalQuestions = Question::count();

        foreach ($request->answers as $questionId => $userAnswer) {
            $question = Question::find($questionId);
            if ($question && $question->correct_option === $userAnswer) {
                $score++;
            }
        }

        $percentage = ($score / $totalQuestions) * 100;
        return view('exam.results', compact('score', 'totalQuestions', 'percentage'));
    }
}

