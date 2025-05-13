@extends('layouts.calm-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-4">
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
