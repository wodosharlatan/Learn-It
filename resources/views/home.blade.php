<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/font.css') }}" >

        <title>Learn It</title>
</head>
<body>
    
        @auth

        <h1>Hello World</h1>

        @else

        <h2>You dont have an account? Register <a href="/">here</a> </h2>


        @endauth

</body>
</html>