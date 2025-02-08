@extends('layouts.app')

@section('title', 'Task List')

@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Task List</h2>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">+ Add Task</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Assigned To</th>
                    <th>Status</th>
                    <th>Sessions</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $index => $task)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ Str::limit($task->description, 50) }}</td>
                    <td>{{ $task->assignedUser->name }}</td>
                    <td>
                        <span class="badge 
                            {{ $task->status == 'pending' ? 'bg-warning' : 
                            ($task->status == 'in_progress' ? 'bg-primary' : 'bg-success') }}">
                            {{ ucfirst($task->status) }}
                        </span>
                    </td>
                    <td>
                        @foreach($task->sessions as $session)
                            <div>{{ $session->start_time }} - {{ $session->end_time ?? 'In Progress' }}</div>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('tasks.start-session', $task->id) }}" class="btn btn-sm btn-success">Start</a>
                        <a href="{{ route('tasks.end-session', $task->id) }}" class="btn btn-sm btn-danger">End</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
