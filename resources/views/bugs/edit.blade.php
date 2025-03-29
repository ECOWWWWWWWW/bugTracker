@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Edit Bug
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('bugs.update', $bug->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="title">Bug Title</label>
                            <input type="text" name="title" class="form-control" id="title" value="{{ old('title', $bug->title) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" id="description" rows="4" required>{{ old('description', $bug->description) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="priority">Priority</label>
                            <select name="priority" class="form-control" id="priority" required>
                                <option value="low" {{ old('priority', $bug->priority) == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('priority', $bug->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ old('priority', $bug->priority) == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control" id="status" required>
                                <option value="open" {{ $bug->status == 'open' ? 'selected' : '' }}>Open</option>
                                <option value="in_progress" {{ $bug->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="resolved" {{ $bug->status == 'resolved' ? 'selected' : '' }}>Resolved</option>                                
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">Update Bug</button>
                            <a href="{{ route('bugs.index') }}" class="btn btn-secondary">Back to List</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
