<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Learn It</title>


</head>

<body>
    <div id="app">


        <div>
            <h1>Home</h1>
            <p>Welcome to the home page</p>
        </div>

        <div>
            <h2>Register </h2>
            <form action="/register" method="POST">
                @csrf
                <label for="name">Name</label>
                <input type="text" id="name" name="name">

                <label for="email">Email</label>
                <input type="email" id="email" name="email">
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation">
                <button type="submit">Register</button>
            </form>
        </div>


    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
