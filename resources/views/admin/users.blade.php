@extends('layouts.calm-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i data-feather="users" class="me-2"></i>
                        Manage Users
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Joined</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td>{{ $user->created_at->diffForHumans() }}</td>
                                        <td>
                                            @if($user->id !== auth()->id())
                                                <form action="{{ route('admin.users.role.update', $user) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    @if($user->role === 'admin')
                                                        <button type="submit" 
                                                                class="btn btn-warning btn-sm"
                                                                name="role" 
                                                                value="user"
                                                                onclick="return confirm('Are you sure you want to demote this admin?')">
                                                            <i data-feather="user-minus" class="feather-sm"></i>
                                                            Demote to User
                                                        </button>
                                                    @else
                                                        <button type="submit" 
                                                                class="btn btn-promote btn-sm"
                                                                name="role" 
                                                                value="admin" style="background-color: #29801e; border-color: #ffffff; color: rgb(255, 255, 255);"
                                                                onclick="return confirm('Are you sure you want to promote this user to admin?')">
                                                            <i data-feather="user-plus" class="feather-sm"></i>
                                                            Make Admin
                                                        </button>
                                                    @endif
                                                </form>
                                            @else
                                                <span class="text-muted">Current User</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .feather-sm {
        width: 16px;
        height: 16px;
        vertical-align: middle;
        margin-right: 6px;
    }

    .btn-promote {
        background-color: #FFA500 !important;
        border-color: #FFA500 !important;
        color: white !important;
        border-radius: 20px;
        padding: 0.375rem 1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .btn-promote:hover {
        background-color: #FF8C00 !important;
        border-color: #FF8C00 !important;
        color: white !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .btn-warning {
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush

