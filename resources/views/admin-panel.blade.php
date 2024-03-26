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
            @if (auth()->user()->admin == 1)
                <h1>Admin Panel</h1>

                <h2>Go to <a href="/home">Dashboard</a></h2>
                <br><br><br>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @else
                <h2>You are not an admin</h2>
            @endif
        @else
            <h2>You don't have an account? Register <a href="/">here</a></h2>
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
