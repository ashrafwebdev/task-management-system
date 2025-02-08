@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Task List</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Assigned To</th>
                <th>Current Status</th>
                <th>Last Updated By</th>
               
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->assignedUser->name ?? 'Unassigned' }}</td>
                    <td>
                        <form action="{{ route('tasks.updateStatus', $task->id) }}" method="POST">
                            @csrf
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        @if($task->statusHistories->isNotEmpty())
                            <a href="#" data-bs-toggle="modal" data-bs-target="#statusHistoryModal" 
                               onclick="showHistory({{ $task->id }})">
                                {{ $task->statusHistories->last()->changedByUser->name }} 
                                ({{ $task->statusHistories->last()->created_at->format('Y-m-d H:i:s') }})
                            </a>
                        @else
                            No changes
                        @endif
                    </td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Status History Modal -->
<div class="modal fade" id="statusHistoryModal" tabindex="-1" aria-labelledby="statusHistoryLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="statusHistoryLabel">Task Status History</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table">
          <thead>
            <tr>
              <th>Changed By</th>
              <th>Old Status</th>
              <th>New Status</th>
              <th>Timestamp</th>
            </tr>
          </thead>
          <tbody id="statusHistoryContent">
            <!-- History will be loaded here -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection
