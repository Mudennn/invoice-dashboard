<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'E-Invoice' }}</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet" />

    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])

    @include('layouts.styles.index')
    @include('layouts.styles.tables')
    @include('layouts.styles.sidebar')
    @include('layouts.styles.mobile_header')
    @include('layouts.styles.from')
    @include('layouts.styles.profile')
</head>

<body class="bg-background">
    <!-- Mobile Header -->
    @include('layouts.components.mobile_header')

    <div class="wrapper">
        <!-- Sidebar -->
        @include('layouts.components.sidebar')

        <div class="main-content">
            @yield('content')
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#invoiceTable').DataTable({
                responsive: false,
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                pagingType: 'full_numbers',
                dom: '<"top"lf>rt<"bottom"ip><"clear">',
            });
        });
    </script>
    @include('sweetalert::alert')
    @stack('scripts')
</body>

</html>
