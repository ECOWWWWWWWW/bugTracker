@extends('layouts.calm-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i data-feather="bug" class="me-2"></i>
                        Manage Bugs
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Priority</th>
                                    <th>Reported By</th>
                                    <th>Assigned To</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bugs as $bug)
                                    <tr>
                                        <td>{{ $bug->title }}</td>
                                        <td>
                                            <span class="badge bg-{{ $bug->status === 'open' ? 'info' : ($bug->status === 'in_progress' ? 'warning' : 'success') }}">
                                                {{ ucfirst(str_replace('_', ' ', $bug->status)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $bug->priority === 'low' ? 'success' : ($bug->priority === 'medium' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($bug->priority) }}
                                            </span>
                                        </td>
                                        <td>{{ $bug->user->name }}</td>
                                        <td>
                                            {{ $bug->assignedUser ? $bug->assignedUser->name : 'Unassigned' }}
                                        </td>
                                        <td>{{ $bug->created_at->diffForHumans() }}</td>
                                        <td>
                                            <button type="button" 
                                                    class="btn btn-sm btn-primary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#assignModal{{ $bug->id }}">
                                                Assign
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No bugs found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $bugs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($bugs as $bug)
    <div class="modal fade" id="assignModal{{ $bug->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.bugs.assign', ['bug' => $bug->id]) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Assign Bug: {{ $bug->title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="assigned_to" class="form-label">Assign to User</label>
                            <select class="form-select" name="assigned_to" required>
                                <option value="">Select User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $bug->assigned_to == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Assign Bug</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
@endsection