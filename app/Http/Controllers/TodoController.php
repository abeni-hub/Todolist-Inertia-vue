<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        return Inertia::render('Todos/Index', [
            'todos' => $todos,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'task' => 'required|string|max:255',
        ]);

        Todo::create($validated);

        return redirect()->back();
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return redirect()->back();
    }

    public function toggle(Todo $todo)  // Renamed from 'update' for clarity
    {
        $todo->update(['completed' => !$todo->completed]);
        return redirect()->back();
    }

    public function updateTask(Request $request, Todo $todo)  // New method for editing task
    {
        $validated = $request->validate([
            'task' => 'required|string|max:255',
        ]);

        $todo->update($validated);

        return redirect()->back();
    }
}