@extends('layouts.app')

@section('title', 'Create Task')

@section('content')

<div class="container mt-4">
    <h2>Create Task</h2>
    <div class="card shadow-sm p-4">
        <form method="POST" action="{{ route('tasks.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Title:</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description:</label>
                <textarea name="description" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Assign To:</label>
                <select name="assigned_to" class="form-control">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Create Task</button>
        </form>
    </div>
</div>

@endsection
