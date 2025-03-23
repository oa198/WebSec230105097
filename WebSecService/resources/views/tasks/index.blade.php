@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">📌 To-Do List</h2>

    <div class="card p-3 shadow-sm">
        <!-- Form لإضافة مهمة جديدة -->
        <form method="POST" action="{{ route('tasks.store') }}" class="d-flex mb-3">
            @csrf
            <input type="text" name="name" class="form-control me-2" placeholder="New Task" required>
            <button type="submit" class="btn btn-primary">Add Task</button>
        </form>

        <!-- قائمة المهام -->
        <ul class="list-group">
            @foreach ($tasks as $task)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="{{ $task->status ? 'text-success text-decoration-line-through' : '' }}">
                        {{ $task->name }}
                    </span>

                    <div>
                        @if (!$task->status)
                            <form method="POST" action="{{ route('tasks.update', $task->id) }}" class="d-inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success">✅ Done</button>
                            </form>
                        @endif

                        <form method="POST" action="{{ route('tasks.destroy', $task->id) }}" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">🗑 Delete</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
