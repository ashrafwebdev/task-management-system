<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskSession;
use Illuminate\Http\Request;
use App\Models\TaskStatusHistory;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('assignedUser', 'sessions','statusHistories.user')->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $users = \App\Models\User::where('role_id', 3)->get();
        return view('tasks.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'assigned_to' => 'required|exists:users,id'
        ]);

        Task::create($request->all());
        return redirect()->route('tasks.index')->with('success', 'Task Created Successfully');
    }

    public function startSession($id)
    {
        TaskSession::create([
            'task_id' => $id,
            'start_time' => now(),
        ]);

        return back()->with('success', 'Task session started.');
    }

    public function endSession($id)
    {
        $session = TaskSession::where('task_id', $id)->whereNull('end_time')->first();

        if ($session) {
            $session->update(['end_time' => now()]);
        }

        return back()->with('success', 'Task session ended.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        // Log the old status before changing it
        TaskStatusHistory::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'old_status' => $task->status,
            'new_status' => $request->status,
        ]);

        // Update task status
        $task->update(['status' => $request->status]);

        return back()->with('success', 'Task status updated successfully.');
    }

    public function getStatusHistory($id)
{
    $task = Task::findOrFail($id);

    $history = $task->statusHistories->map(function ($record) {
        return [
            'changed_by' => $record->changedByUser->name,
            'old_status' => ucfirst($record->old_status),
            'new_status' => ucfirst($record->new_status),
            'timestamp' => $record->created_at->format('Y-m-d H:i:s'),
        ];
    });

    return response()->json($history);
}

}

