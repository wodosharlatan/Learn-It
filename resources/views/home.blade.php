<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/mainStyles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/homeStyle.css') }}">

    <title>Learn It</title>
</head>

<body>

    @auth

        <h1>Welcome to Learn-It</h1>

        <ul>
            @foreach ($reservations as $reservation)
                <h1> Day: {{ $reservation->date }} </h1>


                <li> Student's Name: {{ $reservation->name }}</li>
                <li> Starts: {{ $reservation->starts_at }}</li>
                <li> Ends: {{ $reservation->ends_at }}</li>
                <li> Subject: {{ $reservation->subject }}</li>

            @endforeach
        </ul>

        <form action="/new-reservation" method="POST">
            @csrf

            <label for="time">Time From</label>
            <input type="datetime-local" id="time" name="time_from">


            <label for="time">Time To</label>
            <input type="datetime-local" id="time" name="time_to">

            <label for="subject">Subject</label>
            <input type="text" id="subject" name="subject">



            <button type="submit">Reserve</button>
        </form>
    @else
        <h2>You dont have an account? Register <a href="/">here</a> </h2>


    @endauth

</body>

</html>
