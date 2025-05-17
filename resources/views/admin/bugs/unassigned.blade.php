@extends('layouts.calm-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <i data-feather="alert-circle" class="me-2"></i>
                    Unassigned Bugs
                </div>

                <div class="card-body">
                    @if($bugs->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Priority</th>
                                        <th>Reported By</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bugs as $bug)
                                        <tr>
                                            <td>{{ $bug->title }}</td>
                                            <td>
                                                <span class="badge bg-{{ $bug->priority === 'low' ? 'info' : ($bug->priority === 'medium' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($bug->priority) }}
                                            </span>
                                            </td>
                                            <td>{{ $bug->user->name }}</td>
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center mb-0">No unassigned bugs found.</p>
                    @endif
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
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="assigned_to" class="form-label">Assign to Team Member</label>
                            <select class="form-select" name="assigned_to" required>
                                <option value="">Select User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
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