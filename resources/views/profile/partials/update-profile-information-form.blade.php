@extends('layouts.calm-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-4">
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
                                   value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                            @if ($errors->has('name'))
                                <div class="text-danger mt-2">{{ $errors->first('name') }}</div>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input id="email" name="email" type="email" class="form-control"
                                   value="{{ old('email', $user->email) }}" required autocomplete="username">
                            @if ($errors->has('email'))
                                <div class="text-danger mt-2">{{ $errors->first('email') }}</div>
                            @endif

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
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
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnIcons = document.querySelectorAll('.feather-sm');
        btnIcons.forEach(icon => {
            icon.setAttribute('width', '16');
            icon.setAttribute('height', '16');
        });
    });
</script>
@endsection
