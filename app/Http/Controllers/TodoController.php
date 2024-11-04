<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class TodoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|string|max:255',
            'due_date' => 'nullable|date',
        ]);

        $user = Auth::user();
        $todo = new Todo();
        $todo->user_id = $user->id;
        $todo->task = $request->task;
        $todo->due_date = $request->due_date;
        $todo->save();

        return redirect('/dashboard');
    }

    public function update(Request $request, Todo $todo): JsonResponse
    {
        $request->validate([
            'task' => 'required|string|max:255',
            'due_date' => 'nullable|date',
            'completed' => 'boolean',
        ]);

        $todo->task = $request->task;
        $todo->due_date = $request->due_date;
        $todo->completed = $request->completed;
        $todo->save();

        return response()->json(['success' => true]);
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return redirect('/dashboard');
    }

    public function complete(Todo $todo)
    {
        $todo->completed = !$todo->completed;
        $todo->save();
        return redirect('/dashboard');
    }
}
