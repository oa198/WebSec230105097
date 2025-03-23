<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->get();
        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);

        Task::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back();
    }

    public function update(Task $task)
    {
        if ($task->user_id == Auth::id()) {
            $task->update(['status' => 1]);
        }

        return redirect()->back();
    }

    public function destroy(Task $task)
    {
        if ($task->user_id == Auth::id()) {
            $task->delete();
        }

        return redirect()->back();
    }
}
