<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/mainStyles.css') }}">
    <title>Learn It</title>



</head>

<body>

    <div id="app">


        @auth

            <h1>Already Logged In</h1>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit">Logout</button>
            </form>
            <h2>Go to <a href="/home">Dashboard</a> </h2>
        @else
            @if ($errors->any())
                <ul id="errors">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <br><br><br>

            <div>
                <h1>Home</h1>
                <p>Welcome to the home page</p>
            </div>

            <br><br>

            <div>
                <h2>Register </h2>
                <form id="form" action="/register" method="POST">
                    @csrf
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"><br>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"><br>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" value="{{ old('password') }}"><br>

                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        value="{{ old('password_confirmation') }}"><br>


                    <button type="submit">Register</button>
                </form>
            </div>

            <div>
                <h2>Login </h2>
                <form id="form" action="/login" method="POST">
                    @csrf
                    <label for="email">Email</label>
                    <input type="email" id="email" name="login_email" value="{{ old('login_email') }}"><br>


                    <label for="password">Password</label>
                    <input type="password" id="password" name="login_password" value="{{ old('login_password') }}"><br>


                    <button type="submit">Login</button>
                </form>
            </div>

        @endauth

    </div>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <script src="{{ asset('js/app.js') }}"></script>


</body>

</html>
