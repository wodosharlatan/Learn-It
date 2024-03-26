<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/mainStyles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/homeStyle.css') }}">

    <title>Learn It</title>
</head>

<body>

    <div id="app">
        @auth

            <h1>Welcome to Learn-It</h1>
            <br><br>

            <ul>
                @foreach ($reservations as $reservation)
                    <h1> Day: {{ $reservation->date }} </h1>


                    <li> Student's Name: {{ $reservation->name }}</li>
                    <li> Starts: {{ $reservation->starts_at }}</li>
                    <li> Ends: {{ $reservation->ends_at }}</li>
                    <li> Subject: {{ $reservation->subject }}</li>



                    @if (auth()->user()->id == $reservation->user_id)
                        <form action="/delete-reservation/{{ $reservation->id }}" method="POST">
                            @csrf
                            <button type="submit">Delete</button>
                        </form>
                    @endif

                    <br>

                @endforeach
            </ul>

            <br><br><br>

            @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <br><br><br>

            <form id="form" action="/new-reservation" method="POST">
                @csrf

                <label for="time">Time From</label>
                <input type="datetime-local" id="time" name="time_from" value="{{ old('time_from') }}">


                <label for="time">Time To</label>
                <input type="datetime-local" id="time" name="time_to" value="{{ old('time_to') }}">

                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" value="{{ old('subject') }}">


                <button type="submit">Reserve</button>
            </form>
        @else
            <h2>You dont have an account? Register <a href="/">here</a> </h2>


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
