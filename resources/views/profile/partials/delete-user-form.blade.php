@extends('layouts.calm-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-4">
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
