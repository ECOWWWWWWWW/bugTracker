@extends('layouts.calm-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i data-feather="edit-3" class="me-2"></i>
                    Edit Bug
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('bugs.update', $bug->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="{{ old('title', $bug->title) }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" 
                                      rows="5" required>{{ old('description', $bug->description) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="priority">Priority</label>
                                    <select class="form-control" id="priority" name="priority" required>
                                        <option value="low" {{ (old('priority', $bug->priority) == 'low') ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ (old('priority', $bug->priority) == 'medium') ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ (old('priority', $bug->priority) == 'high') ? 'selected' : '' }}>High</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="open" {{ (old('status', $bug->status) == 'open') ? 'selected' : '' }}>Open</option>
                                        <option value="in progress" {{ (old('status', $bug->status) == 'in progress') ? 'selected' : '' }}>In Progress</option>
                                        <option value="resolved" {{ (old('status', $bug->status) == 'resolved') ? 'selected' : '' }}>Resolved</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4 d-flex justify-content-between">
                            <a href="{{ route('bugs.index') }}" class="btn btn-secondary">
                                <i data-feather="arrow-left" class="feather-sm"></i> Back to List
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i data-feather="save" class="feather-sm"></i> Update Bug
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Bug History Card (optional enhancement) -->
            <div class="card mt-4">
                <div class="card-header">
                    <i data-feather="clock" class="me-2"></i>
                    Bug History
                </div>
                <div class="card-body">
                    <ul class="timeline">
                        <li class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h3 class="timeline-title">Created</h3>
                                <p>{{ $bug->created_at->format('F j, Y, g:i a') }}</p>
                                <p>Reported by: {{ $bug->user->name }}</p>
                            </div>
                        </li>
                        @if($bug->created_at != $bug->updated_at)
                            <li class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h3 class="timeline-title">Last Updated</h3>
                                    <p>{{ $bug->updated_at->format('F j, Y, g:i a') }}</p>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Timeline styles */
    .timeline {
        position: relative;
        padding-left: 40px;
        margin-bottom: 50px;
        list-style-type: none;
    }

    .timeline:before {
        content: '';
        position: absolute;
        top: 0;
        left: 15px;
        height: 100%;
        width: 2px;
        background: var(--secondary-color);
    }

    .timeline-item {
        position: relative;
        margin-bottom: 30px;
    }

    .timeline-marker {
        position: absolute;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        left: -30px;
        background: var(--primary-color);
        box-shadow: 0 0 0 4px var(--secondary-color);
    }

    .timeline-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 5px;
        color: var(--primary-color);
    }

    .timeline-content p {
        margin-bottom: 5px;
        font-size: 0.9rem;
        color: var(--light-text);
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Make the Feather icons smaller in buttons
        const btnIcons = document.querySelectorAll('.feather-sm');
        btnIcons.forEach(icon => {
            icon.setAttribute('width', '16');
            icon.setAttribute('height', '16');
        });
    });
</script>
@endsection
