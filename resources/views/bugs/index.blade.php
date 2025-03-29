@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Bug List
                    <a href="{{ route('bugs.create') }}" class="btn btn-primary float-right">Create New Bug</a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($bugs->isEmpty())
                        <p>No bugs reported yet.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Reported By</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bugs as $bug)
                                    <tr>
                                        <td>{{ $bug->title }}</td>
                                        <td>{{ Str::limit($bug->description, 50) }}</td>
                                        <td>{{ ucfirst($bug->priority) }}</td>
                                        <td>{{ ucfirst($bug->status) }}</td>
                                        <td>{{ $bug->user->name }}</td>
                                        <td>
                                            <a href="{{ route('bugs.edit', $bug->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                            <form action="{{ route('bugs.destroy', $bug->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this bug?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
