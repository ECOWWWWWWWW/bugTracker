<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Zerobugz</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="navbar-brand">ZeroBugz</h1>

        <form method="POST" class="box" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                @if ($errors->has('name'))
                    <div class="error">{{ $errors->first('name') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="birthdate" class="form-label">Birth Date</label>
                <input id="birthdate" type="date" name="birthdate" 
                       value="{{ old('birthdate') }}" 
                       required
                       max="{{ date('Y-m-d', strtotime('-18 years')) }}"
                       oninvalid="this.setCustomValidity('You must be at least 18 years old to register')"
                       oninput="this.setCustomValidity('')">
                @if ($errors->has('birthdate'))
                    <div class="error">{{ $errors->first('birthdate') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="phone_number" class="form-label">Phone Number</label>
                <div class="input-wrapper">
                    <span class="input-prefix">+63</span>
                    <input id="phone_number" name="phone_number" type="text"
                        class="input-text"
                        placeholder="9123456789" pattern="\d{10}" required
                        value="{{ old('phone_number') }}">
                </div>
                @if ($errors->has('phone_number'))
                    <div class="input-error">{{ $errors->first('phone_number') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
                @if ($errors->has('email'))
                    <div class="error">{{ $errors->first('email') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password">
                @if ($errors->has('password'))
                    <div class="error">{{ $errors->first('password') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
                @if ($errors->has('password_confirmation'))
                    <div class="error">{{ $errors->first('password_confirmation') }}</div>
                @endif
            </div>

            <div class="actions">
                <a href="{{ route('login') }}" class="link">Already registered?</a>
                <button type="submit">Register</button>
            </div>
        </form>
    </div>
</body>
</html>
