@extends('layouts.calm-app')

@section('content')
<div class="container">
    <h1>Edit Profile</h1>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i data-feather="user" class="me-2"></i>
                    Profile Information
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">
                        Update your account's profile information and email address.
                    </p>

                    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
                        @csrf
                    </form>

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="form-group mb-3">
                            <label for="name">Name</label>
                            <input id="name" name="name" type="text" class="form-control"
                                   value="{{ old('name', auth()->user()->name) }}" required autofocus autocomplete="name">
                            @if ($errors->has('name'))
                                <div class="text-danger mt-2">{{ $errors->first('name') }}</div>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input id="email" name="email" type="email" class="form-control"
                                   value="{{ old('email', auth()->user()->email) }}" required autocomplete="username">
                            @if ($errors->has('email'))
                                <div class="text-danger mt-2">{{ $errors->first('email') }}</div>
                            @endif

                            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                                <div class="mt-3">
                                    <p class="text-muted">
                                        Your email address is unverified.
                                        <button form="send-verification" class="btn btn-link p-0 align-baseline">
                                            Click here to re-send the verification email.
                                        </button>
                                    </p>
                                    @if (session('status') === 'verification-link-sent')
                                        <p class="text-success small mt-1">
                                            A new verification link has been sent to your email address.
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i data-feather="save" class="feather-sm"></i> Save
                            </button>

                            @if (session('status') === 'profile-updated')
                                <span class="text-success small">Saved.</span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i data-feather="lock" class="me-2"></i>
                    Update Password
                </div>
                <div class="card-body">
                    <p class="mb-4 text-muted">
                        Ensure your account is using a long, random password to stay secure.
                    </p>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="form-group mb-3">
                            <label for="update_password_current_password">Current Password</label>
                            <input id="update_password_current_password" name="current_password" type="password"
                                   class="form-control" autocomplete="current-password" required>
                            @if ($errors->updatePassword->has('current_password'))
                                <div class="text-danger mt-2">
                                    {{ $errors->updatePassword->first('current_password') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label for="update_password_password">New Password</label>
                            <input id="update_password_password" name="password" type="password"
                                   class="form-control" autocomplete="new-password" required>
                            @if ($errors->updatePassword->has('password'))
                                <div class="text-danger mt-2">
                                    {{ $errors->updatePassword->first('password') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group mb-4">
                            <label for="update_password_password_confirmation">Confirm Password</label>
                            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                                   class="form-control" autocomplete="new-password" required>
                            @if ($errors->updatePassword->has('password_confirmation'))
                                <div class="text-danger mt-2">
                                    {{ $errors->updatePassword->first('password_confirmation') }}
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-primary">
                                <i data-feather="save" class="feather-sm"></i> Save
                            </button>

                            @if (session('status') === 'password-updated')
                                <span class="text-success small">Saved.</span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <i data-feather="alert-circle" class="me-2"></i>
                    Delete Account
                </div>
                <div class="card-body">
                    @if ($errors->userDeletion->isNotEmpty())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->userDeletion->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <p class="mb-4 text-muted">
                        Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
                    </p>

                    <form method="POST" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')

                        <div class="form-group mb-3">
                            <label for="password">Password</label>
                            <input id="password" name="password" type="password" class="form-control" placeholder="Enter your password" required>
                            @if ($errors->userDeletion->has('password'))
                                <div class="text-danger mt-2">
                                    {{ $errors->userDeletion->first('password') }}
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                <i data-feather="arrow-left" class="feather-sm"></i> Cancel
                            </a>

                            <button type="submit" class="btn btn-danger">
                                <i data-feather="trash-2" class="feather-sm"></i> Delete Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Feather icons
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
        
        const btnIcons = document.querySelectorAll('.feather-sm');
        btnIcons.forEach(icon => {
            icon.setAttribute('width', '16');
            icon.setAttribute('height', '16');
        });

        const formInputs = document.querySelectorAll('.form-control');
        formInputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('animate__animated', 'animate__pulse');
            });

            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('animate__animated', 'animate__pulse');
            });
        });
    });
</script>
@endsection