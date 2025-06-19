<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'E-Invoice' }}</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet" />

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @include('layouts.styles.index')
    @include('layouts.styles.from')
    @include('layouts.styles.login')
</head>

<body class="bg-background">
    <div class="d-flex justify-content-center align-items-center h-100">
        @yield('content')
    </div>
</body>

</html>
