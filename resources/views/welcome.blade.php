<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ZeroBugs</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #fff;
            color: #000;
        }
        .top-right {
            position: absolute;
            right: 1.5rem;
        }
        .top-right a {
            color: #000;
            font-weight: 600;
            text-decoration: none;
        }
        .top-right a:hover {
            text-decoration: underline;
        }
        .main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            height: 100vh;
            margin-top: -70px;
            
        }
        .main img {
            height: 500px;
        }
        .main h1 {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        .main p {
            font-size: 1.55rem;
            max-width: 500px;
            margin-bottom: 2rem;
        }
        .main a.button {
            background-color: #000;
            font-size: 1rem;
            color: #fff;
            padding: 0.75rem 2rem;
            border: none;
            text-decoration: none;
            font-weight: 600;
            border-radius: 4px;
        }
        .main a.button:hover {
            background-color: #494949;
        }
        .main a.login{
            padding: .5rem;
            color: #000;
            font-size: 13px;
        }
        .main a.login:hover{
            color: #c27979
        }
    </style>
</head>
<body>
    
    <div class="main">
        <img src="{{ asset('images/landing-logo.svg') }}" alt="ZeroBugs Logo">
        <h1>ZeroBugs. Zero Problems.</h1>
        <p>Track, squash, and fix bugs fast with the simplest bug tracker you'll ever use.</p>
        <a href="{{ route('register') }}" class="button">Start Tracking Bugs</a>
        <a href="{{ route('login') }}" class="login">Already have an account?</a>
    </div>
</body>
</html>
