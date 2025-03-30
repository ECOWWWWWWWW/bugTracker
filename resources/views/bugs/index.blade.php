@extends('layouts.calm-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>
                        <i data-feather="alert-circle" class="me-2"></i>
                        Bug Tracker
                    </span>
                    <div>
                        <a href="{{ route('bugs.create') }}" class="btn btn-primary">
                            <i data-feather="plus" class="feather-sm"></i>
                            New Bug
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        @include('components.notification', ['type' => 'success', 'message' => session('success')])
                    @endif

                    <!-- View toggle buttons -->
                    <div class="view-toggle mb-4 d-flex justify-content-end">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn active" data-view="list">
                                <i data-feather="list" class="feather-sm"></i> List
                            </button>
                            <button type="button" class="btn" data-view="grid">
                                <i data-feather="grid" class="feather-sm"></i> Grid
                            </button>
                        </div>
                    </div>

                    @if($bugs->isEmpty())
                        <div class="empty-state">
                            <div class="empty-state__icon">
                                <i data-feather="check-circle"></i>
                            </div>
                            <p class="empty-state__message">No bugs reported yet. Enjoy the calm!</p>
                            <a href="{{ route('bugs.create') }}" class="btn btn-primary">Report First Bug</a>
                        </div>
                    @else
                        <!-- List View -->
                        <div id="list-view">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="20%">Title</th>
                                            <th width="25%">Description</th>
                                            <th width="10%">Priority</th>
                                            <th width="10%">Status</th>
                                            <th width="15%">Reported By</th>
                                            <th width="20%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bugs as $bug)
                                            <tr>
                                                <td>{{ $bug->title }}</td>
                                                <td>{{ Str::limit($bug->description, 50) }}</td>
                                                <td>
                                                    <span class="badge badge-{{ strtolower($bug->priority) }}">
                                                        {{ ucfirst($bug->priority) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-{{ str_replace(' ', '-', strtolower($bug->status)) }}">
                                                        {{ ucfirst($bug->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $bug->user->name }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('bugs.edit', $bug->id) }}" class="btn btn-warning btn-sm me-2" title="Edit Bug">
                                                            <i data-feather="edit-2" class="feather-sm"></i>
                                                        </a>
                                                        
                                                        <form action="{{ route('bugs.destroy', $bug->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                                    onclick="return confirm('Are you sure you want to delete this bug?')"
                                                                    title="Delete Bug">
                                                                <i data-feather="trash-2" class="feather-sm"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Grid View -->
                        <div id="grid-view" style="display: none;">
                            <div class="row">
                                @foreach($bugs as $bug)
                                    <div class="col-md-4 mb-4">
                                        @include('components.bug-card', ['bug' => $bug])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Make the Feather icons smaller in the table
        const tableIcons = document.querySelectorAll('.feather-sm');
        tableIcons.forEach(icon => {
            icon.setAttribute('width', '16');
            icon.setAttribute('height', '16');
        });
    });
</script>
@endsection
