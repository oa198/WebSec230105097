<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller {
    public function index() {
        $grades = Grade::all();
        return view('grades.index', compact('grades'));
    }

    public function create() {
        return view('grades.create');
    }

    public function store(Request $request) {
        Grade::create($request->all());
        return redirect()->route('grades.index');
    }
}
